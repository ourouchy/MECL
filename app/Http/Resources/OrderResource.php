<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderResource extends JsonResource
{
    public static $wrap = false;

    public function toArray($request)
    {
        $customer = $this->user?->customer;
        $shipping = $customer?->shippingAddress;
        $billing = $customer?->billingAddress;

        return [
            'id' => $this->id,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'items' => $this->items->map(fn($item) => [
                'id' => $item->id,
                'unit_price' => $item->unit_price,
                'quantity' => $item->quantity,
                'size_id' => $item->size_id,
                'size' => $item->size_id
                    ? optional($item->product->sizes->firstWhere('id', $item->size_id))->name
                    : null,
                'product' => [
                    'id' => $item->product->id,
                    'slug' => $item->product->slug,
                    'title' => $item->product->title,
                    'image' => $item->product->image,
                ]
            ]),
            'customer' => [
                'id' => $this->user?->id,
                'email' => $this->user?->email ?? $this->guest_email,
                'first_name' => $customer?->first_name ?? $this->guest_first_name,
                'last_name' => $customer?->last_name ?? $this->guest_last_name,
                'phone' => $customer?->phone ?? $this->guest_phone,
                'shippingAddress' => [
                    'address1' => $shipping?->address1 ?? $this->guest_address1,
                    'address2' => $shipping?->address2 ?? $this->guest_address2,
                    'city' => $shipping?->city ?? $this->guest_city,
                    'state' => $shipping?->state ?? $this->guest_state,
                    'zipcode' => $shipping?->zipcode ?? $this->guest_zipcode,
                    'country' => $shipping?->country->name ?? $this->guest_country,
                ],
                'billingAddress' => [
                    'address1' => $billing?->address1 ?? $this->guest_address1,
                    'address2' => $billing?->address2 ?? $this->guest_address2,
                    'city' => $billing?->city ?? $this->guest_city,
                    'state' => $billing?->state ?? $this->guest_state,
                    'zipcode' => $billing?->zipcode ?? $this->guest_zipcode,
                    'country' => $billing?->country->name ?? $this->guest_country,
                ],
            ],
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
