<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;
use App\Http\Resources\ReviewResource;


class ProductResource extends JsonResource
{
    public static $wrap = false;

    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'image_url' => $this->image,
            'images' => $this->images,
            'price' => $this->price,
            'original_price' => $this->original_price,
            'quantity' => $this->quantity,
            'published' => (bool)$this->published,
            'categories' => $this->categories->map(fn($c) => $c->id),
            'created_at' => (new \DateTime($this->created_at))->format('Y-m-d H:i:s'),
            'updated_at' => (new \DateTime($this->updated_at))->format('Y-m-d H:i:s'),
            'brand' => $this->brand ? [
                'id' => $this->brand->id,
                'name' => $this->brand->name,
                'image' => $this->brand->image,
            ] : null,
            'reviews' => ReviewResource::collection($this->whenLoaded('reviews')),
            'average_rating' => round($this->reviews->avg('rating'), 1),
            'review_count' => $this->reviews->count(),
        ];
    }
}
