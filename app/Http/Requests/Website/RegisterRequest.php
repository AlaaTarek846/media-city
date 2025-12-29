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
            'mobile' => 'required|string',
            'whatsapp' => 'required|string',
            'password' => 'required|min:8|max:50',
            'confirmation' => 'required|same:password',
            'how_did_you_hear_about_us' => 'required|string|max:200',
        ];
    }
}
