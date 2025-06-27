<?php

namespace App\Http\Controllers;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;
use App\Helpers\Cart;
use App\Mail\NewOrderEmail;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class CheckoutController extends Controller
{
    public function checkout(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        $customer = $user?->customer;
        if ($user && (!$customer->billingAddress || !$customer->shippingAddress)) {
            return redirect()->route('profile')->with('error', 'Please provide your address details first.');
        }

        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        [$products, $cartItems] = \App\Helpers\Cart::getProductsAndCartItems();

        $orderItems = [];
        $lineItems = [];
        $totalPrice = 0;

        DB::beginTransaction();

        foreach ($cartItems as $line) {
            $product = $products->firstWhere('id', $line['product_id']);
            if (!$product) {
                continue;
            }
            $quantity = $line['quantity'];
            $sizeId   = $line['size_id'] ?? null;
            $unitPrice = $product->getPriceBySize($sizeId);
            $totalPrice += $unitPrice * $quantity;

            $matchingSize = $product->sizes->firstWhere('id', $sizeId);
            $sizeName = $matchingSize ? $matchingSize->name : null;

            // Ensure that the image URL is absolute and publicly accessible.
            // secure_asset() will generate an absolute URL using HTTPS if available.
            $imageUrl = $product->image ? secure_asset($product->image) : '';

            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        // Append size info to product title if available.
                        'name' => $product->title . ($sizeName ? " (Size: {$sizeName})" : ""),
                        // Pass the image URL as an array. Stripe requires a fully-qualified HTTPS URL.
                        'images' => $imageUrl ? [$imageUrl] : [],
                        'metadata' => [
                            'size' => $sizeName ?? '',
                            'quantity' => $quantity,
                        ],
                    ],
                    'unit_amount' => $unitPrice * 100,
                ],
                'quantity' => $quantity,
            ];

            $orderItems[] = [
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'unit_price' => $unitPrice,
                'size_id'    => $sizeId,
            ];


        }

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_creation' => 'always',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
            'customer_email' => $user ? $user->email : $request->input('email'), // << Add this
            'metadata' => [ // << Add this too
                'guest_first_name' => $user ? '' : $request->input('first_name'),
                'guest_last_name' => $user ? '' : $request->input('last_name'),
                'guest_phone' => $user ? '' : $request->input('phone'),
                'guest_address1' => $user ? '' : $request->input('address1'),
                'guest_address2' => $user ? '' : $request->input('address2'),
                'guest_city' => $user ? '' : $request->input('city'),
                'guest_state' => $user ? '' : $request->input('state'),
                'guest_country' => $user ? '' : $request->input('country'),
                'guest_zipcode' => $user ? '' : $request->input('zipcode'),
            ],
        ]);

        try {
            $orderData = [
                'total_price' => $totalPrice,
                'status'      => OrderStatus::Unpaid,
                'guest_email' => $user ? null : $request->input('email'),
                'guest_first_name' => $user ? null : $request->input('first_name'),
                'guest_last_name'  => $user ? null : $request->input('last_name'),
                'guest_phone'      => $user ? null : $request->input('phone'),
                'guest_address1'   => $user ? null : $request->input('address1'),
                'guest_address2'   => $user ? null : $request->input('address2'),
                'guest_city'       => $user ? null : $request->input('city'),
                'guest_state'      => $user ? null : $request->input('state'),
                'guest_country'    => $user ? null : $request->input('country'),
                'guest_zipcode'    => $user ? null : $request->input('zipcode'),
                'created_by'  => $user?->id,
                'updated_by'  => $user?->id,
            ];
            $order = \App\Models\Order::create($orderData);

            foreach ($orderItems as $orderItem) {
                $orderItem['order_id'] = $order->id;
                \App\Models\OrderItem::create($orderItem);
            }

            $paymentData = [
                'order_id'   => $order->id,
                'amount'     => $totalPrice,
                'status'     => \App\Enums\PaymentStatus::Pending,
                'guest_email' => $user ? null : $request->input('email'),
                'type'       => 'cc',
                'created_by' => $user?->id,
                'updated_by' => $user?->id,
                'session_id' => $session->id,
            ];
            \App\Models\Payment::create($paymentData);
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::critical(__METHOD__ . ' failed: ' . $e->getMessage());
            throw $e;
        }

        DB::commit();
        if ($user) {
            CartItem::where('user_id', $user->id)->delete();
        }
        return redirect($session->url);
    }

    public function success(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = $request->user();
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        try {
            $session_id = $request->get('session_id');
            $session = \Stripe\Checkout\Session::retrieve($session_id);
            if (!$session) {
                return view('checkout.failure', ['message' => 'Invalid Session ID']);
            }

            $payment = Payment::query()
                ->where(['session_id' => $session_id])
                ->whereIn('status', [PaymentStatus::Pending, PaymentStatus::Paid])
                ->first();
            if (!$payment) {
                throw new NotFoundHttpException();
            }
            if ($payment->status === PaymentStatus::Pending->value) {
                $this->updateOrderAndSession($payment);
            }
            $order = $payment->order; // fetch related order to pass the data to success or failure page
            $customer = \Stripe\Customer::retrieve($session->customer);

            return view('checkout.success', compact('customer', 'order'));
        } catch (NotFoundHttpException $e) {
            throw $e;
        } catch (\Exception $e) {
            return view('checkout.failure', ['message' => $e->getMessage()]);
        }
    }

    public function failure(Request $request)
    {
        return view('checkout.failure', ['message' => ""]);
    }

    public function checkoutOrder(Order $order, Request $request)
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        $lineItems = [];
        foreach ($order->items as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $item->product->title,
                    ],
                    'unit_amount' => $item->unit_price * 100,
                ],
                'quantity' => $item->quantity,
            ];
        }

        $session = \Stripe\Checkout\Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('checkout.success', [], true) . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('checkout.failure', [], true),
            'customer_creation' => 'always', // ✅ Add this line!
        ]);

        $order->payment->session_id = $session->id;
        $order->payment->save();

        return redirect($session->url);
    }

    public function webhook()
    {
        \Stripe\Stripe::setApiKey(getenv('STRIPE_SECRET_KEY'));

        $endpoint_secret = env('WEBHOOK_SECRET_KEY');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch (\UnexpectedValueException $e) {
            // Invalid payload
            return response('', 401);
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            return response('', 402);
        }

        // Handle the event
        switch ($event->type) {
            case 'checkout.session.completed':
                $paymentIntent = $event->data->object;
                $sessionId = $paymentIntent['id'];

                $payment = Payment::query()
                    ->where(['session_id' => $sessionId, 'status' => PaymentStatus::Pending])
                    ->first();
                if ($payment) {
                    $this->updateOrderAndSession($payment);
                }
            // ... handle other event types
            default:
                echo 'Received unknown event type ' . $event->type;
        }

        return response('', 200);
    }

    private function updateOrderAndSession(\App\Models\Payment $payment)
    {
        DB::beginTransaction();
        try {
            $payment->status = \App\Enums\PaymentStatus::Paid->value;
            $payment->update();

            $order = $payment->order;
            $order->status = \App\Enums\OrderStatus::Paid->value;
            $order->update();
            $session = \Stripe\Checkout\Session::retrieve($payment->session_id);

            if ($order->created_by === null && $session->metadata) {
                $order->guest_first_name = $session->metadata->guest_first_name ?? null;
                $order->guest_last_name  = $session->metadata->guest_last_name ?? null;
                $order->guest_phone      = $session->metadata->guest_phone ?? null;
                $order->guest_address1   = $session->metadata->guest_address1 ?? null;
                $order->guest_address2   = $session->metadata->guest_address2 ?? null;
                $order->guest_city       = $session->metadata->guest_city ?? null;
                $order->guest_state      = $session->metadata->guest_state ?? null;
                $order->guest_country    = $session->metadata->guest_country ?? null;
                $order->guest_zipcode    = $session->metadata->guest_zipcode ?? null;
                $order->save();
            }


            foreach ($order->items as $item) {
                $product = $item->product;
                $quantity = $item->quantity;
                $sizeId = $item->size_id;

                if ($product->sizes()->exists() && $sizeId) {
                    // Get the size pivot record
                    $size = $product->sizes()->where('sizes.id', $sizeId)->first();

                    if ($size) {
                        $currentStock = $size->pivot->stock;
                        $newStock = max(0, $currentStock - $quantity);

                        // Update the stock in the pivot table
                        $product->sizes()->updateExistingPivot($sizeId, ['stock' => $newStock]);

                        // Recalculate the total stock
                        $totalStock = $product->sizes()->sum('product_size.stock');
                        $product->quantity = $totalStock;
                        $product->save();
                    }
                } else {
                    // For products without sizes
                    if (!is_null($product->quantity)) {
                        $product->quantity -= $quantity;
                        $product->save();
                    }
                }
            }
        } catch (\Exception $e) {
            DB::rollBack();
            \Illuminate\Support\Facades\Log::critical(__METHOD__ . ' failed: ' . $e->getMessage());
            throw $e;
        }

        DB::commit();

        try {
            $adminUsers = \App\Models\User::where('is_admin', 1)->get();
            foreach ([...$adminUsers, $order->user] as $user) {
                if ($user) {
                    Mail::to($user)->send(new NewOrderEmail($order, (bool)$user->is_admin));
                } elseif ($order->guest_email) {
                    Mail::to($order->guest_email)->send(new NewOrderEmail($order, false));
                }
            }
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::critical('Email sending failed: ' . $e->getMessage());
        }
    }
}
