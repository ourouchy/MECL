<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OrderListResource extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'total_price' => $this->total_price,
            'number_of_items' => $this->items_count,
            'customer' => [
                'id' => $this->user?->id,
                'first_name' => $this->user?->customer?->first_name ?? $this->guest_first_name,
                'last_name' => $this->user?->customer?->last_name ?? $this->guest_last_name,
                'email' => $this->user?->email ?? $this->guest_email, // optional if needed
            ],
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
        ];
    }
}
