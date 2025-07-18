<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'active' => $this->active,
            'description' => $this->description,
            'banner_image' => $this->banner_image ? asset('storage/' . $this->banner_image) : null,
            'selection_image' => $this->selection_image ? asset('storage/' . $this->selection_image) : null,
            'parent_id' => $this->parent_id,
            'parent' => $this->parent ? new CategoryResource($this->parent) : null,
            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
        ];
    }
}
