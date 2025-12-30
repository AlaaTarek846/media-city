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
        $departmentId = $this->input('department_id');
        
        $rules = [
            "translations"         => "nullable|array",
            "translations.*.title" => "required|string",
            "translations.*.description" => "nullable|string",

            "features"         => "nullable|array",
            "features.*.title" => "required|string",
            "department_id" => "required|exists:departments,id",
            "category_id" => "required|exists:categories,id",
            "brand_id" => "required|exists:brands,id",
            "type" => "required|in:standard,variant",
            "condition" => "required|in:new,used,rent",
            "status" =>  "required|boolean",
            'image' => $this->method() == 'PUT' ? 'nullable'.($this->hasFile('image')?'|file|mimes:jpeg,jpg,png,svg,webp':'') : 'required|file|mimes:png,svg,webp,jpg,jpeg' ,
            "groupImages" => "required|array",
            "groupImages.*" => $this->method() == 'PUT' ? 'nullable'.($this->hasFile('image')?'|file|mimes:jpeg,jpg,png,svg,webp':'') : 'required|file|mimes:png,svg,webp,jpg,jpeg',
            "variant" => "required|array",
            "variant.*.sku" => "required|string",
            "variant.*.quantity" => "required|numeric|min:0",
            "variant.*.status" => "required|boolean",
            "attributes" => $this->input('type') === 'variant' ? "required|array" : "nullable|array",
            "attributes.*.attribute_id" => $this->input('type') === 'variant' ? "required|exists:product_attributes,id" : "nullable|exists:product_attributes,id",
            "attributes.*.options" => $this->input('type') === 'variant' ? "required|array" : "nullable|array",
        ];
        
        // إضافة validation حسب department_id
        if ($departmentId == 1 || $departmentId == 2) {
            // للإيجار والمبيعات: price مطلوب
            $rules["variant.*.price"] = "required|numeric|min:0";
            // discount_percentage اختياري (0-100)
            $rules["variant.*.discount_percentage"] = "nullable|numeric|min:0|max:100";
            // price_before_discount مطلوب فقط إذا كان discount_percentage > 0
            $rules["variant.*.price_before_discount"] = "nullable|numeric|min:0";
        }
        
        return $rules;
    }
}
