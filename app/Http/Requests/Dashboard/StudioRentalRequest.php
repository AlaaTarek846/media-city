<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class StudioRentalRequest extends FormRequest
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
        return [
            "status"                     => "required|boolean",
            "translations"               => "nullable|array",
            "translations.*.title"       => "required|string",
            "translations.*.description" => "nullable|string",
            "images"                     => "nullable|array",
            "images.*"                   => "image|mimes:jpeg,png,jpg,gif|max:2048",
            "deleted_images"             => "nullable|array",
            "deleted_images.*"           => "integer|exists:images,id",
        ];
    }
}
