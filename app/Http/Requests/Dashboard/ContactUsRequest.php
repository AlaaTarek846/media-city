<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
        $id = $this->method() == 'PUT' ? last($this->segments()) : null;
        return [
            "translations"         => "nullable|array",
            "translations.*.title" => "required|string",
            "translations.*.description" => "required|string",
            'location' => 'required',
            'phone' => 'required|string',
            'email' => 'required|email',
        ];
    }
}
