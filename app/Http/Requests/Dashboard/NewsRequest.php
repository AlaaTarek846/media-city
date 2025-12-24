<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class NewsRequest extends FormRequest
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
            "translations.*.description" => "required|string",
            "details"         => "nullable|array",
            "details.*.title" => "required|string",
            "details.*.description" => "required|string",
            'image' => $this->method() == 'PUT' ? 'nullable'.($this->hasFile('image')?'|file|mimes:jpeg,jpg,png,svg,webp':'') : 'required|file|mimes:png,svg,webp,jpg,jpeg' ,
        ];
    }
}
