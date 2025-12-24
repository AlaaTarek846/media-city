<?php

namespace App\Http\Requests\Dashboard;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;

class FrequentlyAskedQuestionRequest extends FormRequest
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
        ];
    }
}
