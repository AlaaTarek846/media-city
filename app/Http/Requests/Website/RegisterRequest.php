<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class RegisterRequest extends FormRequest
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
     * Validation rules vary based on user_type:
     * - Person: name, email, mobile, whatsapp, password, how_did_you_hear_about_us
     * - Company/Studio: same as Person
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user_type' => 'required|in:person,company,studio',
            'name' => 'required|string|min:3|max:50',
            'email' => 'required|email|unique:users,email',
            'mobile' => ['required', 'string', 'regex:/^(01[0-9]{9}|201[0-9]{8}|\+20[0-9]{10})$/'],
            'whatsapp' => ['required', 'string', 'regex:/^(01[0-9]{9}|201[0-9]{8}|\+20[0-9]{10})$/'],
            'password' => 'required|min:8|max:50',
            'confirmation' => 'required|same:password',
            'how_did_you_hear_about_us' => 'required|string|max:200',
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
            'mobile.regex' => __('messages.Invalid Egyptian mobile number'),
            'whatsapp.regex' => __('messages.Invalid Egyptian WhatsApp number'),
        ];
    }
}
