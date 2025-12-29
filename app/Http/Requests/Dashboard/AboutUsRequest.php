<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class AboutUsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $isUpdate = $this->method() == 'PUT' || $this->method() == 'PATCH';
        
        return [
            // Main AboutUs translations
            "translations" => "nullable|array",
            "translations.*.title" => "required|string",
            "translations.*.description" => "required|string",
            
            // Images
            'image_1' => 'nullable|file|mimes:jpeg,jpg,png,svg,webp',
            'image_2' => 'nullable|file|mimes:jpeg,jpg,png,svg,webp',
            
            // Features array
            'features' => 'nullable|array',
            'features.*.id' => 'nullable|exists:about_us_features,id',
            'features.*.icon' => 'nullable|file|mimes:jpeg,jpg,png,svg,webp',
            'features.*.translations' => 'nullable|array',
            'features.*.translations.*.title' => 'required_with:features.*.translations|string',
            
            // Statistics array
            'statistics' => 'nullable|array',
            'statistics.*.id' => 'nullable|exists:about_us_statistics,id',
            'statistics.*.icon' => 'nullable|file|mimes:jpeg,jpg,png,svg,webp',
            'statistics.*.value' => 'nullable|string|max:255',
            'statistics.*.translations' => 'nullable|array',
            'statistics.*.translations.*.title' => 'required_with:statistics.*.translations|string',
            'statistics.*.translations.*.description' => 'nullable|string',
        ];
    }
}
