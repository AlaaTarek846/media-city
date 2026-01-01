<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class ContactUsRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|max:255',
            'phone' => ['required', 'string', 'regex:/^(01[0-9]{9}|201[0-9]{8}|\+20[0-9]{10})$/'],
            'message' => 'required|string|min:10',
            'subject' => 'required|string|min:3|max:255',
          
        ];
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.min' => __('messages.Name must be at least 3 characters'),
            'phone.regex' => __('messages.Invalid Egyptian mobile number'),
            'message.min' => __('messages.Message must be at least 10 characters'),
            'subject.min' => __('messages.Subject must be at least 3 characters'),
        ];
    }
}
