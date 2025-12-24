<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:50',
            'phone' => 'required|unique:users,phone,'.auth('user')->id().'',
            'email' => 'required|email|unique:users,email,'.auth('user')->id().'|max:100',
            'password' => 'nullable|min:8|max:50',
            'confirmation' => 'nullable|same:password',
          
        ];
    }
}
