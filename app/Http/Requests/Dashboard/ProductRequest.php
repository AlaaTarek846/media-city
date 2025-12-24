<?php

namespace App\Http\Requests\Dashboard;

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
     * @return array
     */
    public function rules()
    {
        return [
            "translations"         => "nullable|array",
            "translations.*.title" => "required|string",
            "translations.*.description" => "nullable|string",

            "features"         => "nullable|array",
            "features.*.title" => "required|string",
            "category_id" => "required|exists:categories,id",
            "brand_id" => "required|exists:brands,id",
            "type" => "required|in:standard,variant",
            "status" =>  "required|boolean",
            'image' => $this->method() == 'PUT' ? 'nullable'.($this->hasFile('image')?'|file|mimes:jpeg,jpg,png,svg,webp':'') : 'required|file|mimes:png,svg,webp,jpg,jpeg' ,
            "groupImages" => "required|array",
            "groupImages.*" => $this->method() == 'PUT' ? 'nullable'.($this->hasFile('image')?'|file|mimes:jpeg,jpg,png,svg,webp':'') : 'required|file|mimes:png,svg,webp,jpg,jpeg',
            "variant" => "required|array",
            "variant.*.sku" => "required|string",
            "variant.*.price_before_discount" => "required|numeric|min:0",
            "variant.*.discount_percentage" => "required|numeric|min:0|max:100",
            "variant.*.price" => "required|numeric|min:0",
            "variant.*.quantity" => "required|numeric|min:0",
            "variant.*.status" => "required|boolean",
            "attributes" => $this->input('type') === 'variant' ? "required|array" : "nullable|array",
            "attributes.*.attribute_id" => $this->input('type') === 'variant' ? "required|exists:product_attributes,id" : "nullable|exists:product_attributes,id",
            "attributes.*.options" => $this->input('type') === 'variant' ? "required|array" : "nullable|array",
        ];
    }
}
