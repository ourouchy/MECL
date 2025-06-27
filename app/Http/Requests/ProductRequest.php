<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title'             => ['required', 'max:2000'],
            'images.*'          => ['nullable', 'image'],
            'deleted_images.*'  => ['nullable', 'int'],
            'image_positions.*' => ['nullable', 'int'],
            'categories.*'      => ['nullable', 'int', 'exists:categories,id'],
            'price'             => [
                function ($attribute, $value, $fail) {
                    // If no sizes are provided, require a product price.
                    if (empty($this->input('sizes')) && (is_null($value) || $value < 0.01)) {
                        $fail('The product price is required if no sizes are provided.');
                    }
                },
                'nullable', // Allows null if sizes exist.
                'numeric',
                'min:0.01'
            ],
            'original_price' => ['nullable', 'numeric', 'min:0'],
            'quantity'          => ['nullable', 'numeric', 'min:0'],
            'description'       => ['nullable', 'string'],
            'published'         => ['required', 'boolean'],

            // Validation rules for sizes
            'sizes'             => ['nullable', 'array'],
            'sizes.*.id'        => ['nullable', 'integer'],
            'sizes.*.name'      => ['nullable', 'string'],
            'sizes.*.price'     => ['required', 'numeric', 'min:0.01'],
            'sizes.*.stock'     => ['required', 'integer', 'min:0'],
            'sizes.*.original_price' => ['nullable', 'numeric', 'min:0'],
            'brand_id' => 'nullable|exists:brands,id',

        ];
    }
}
