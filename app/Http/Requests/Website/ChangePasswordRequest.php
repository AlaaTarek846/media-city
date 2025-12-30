<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;

class ChangePasswordRequest extends FormRequest
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
            'current_password' => 'required|string',
            'password' => ['required', 'string', 'min:8', 'max:50', 'confirmed'],
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Check if current password matches
            if (!Hash::check($this->current_password, auth('user')->user()->password)) {
                $validator->errors()->add('current_password', __('messages.Current password is incorrect'));
            }
        });
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'current_password.required' => __('messages.Current password is required'),
            'current_password.string' => __('messages.Current password must be a valid text'),
            'password.required' => __('messages.New password is required'),
            'password.string' => __('messages.New password must be a valid text'),
            'password.min' => __('messages.New password must be at least 8 characters'),
            'password.max' => __('messages.New password must not exceed 50 characters'),
            'password.confirmed' => __('messages.Password confirmation does not match'),
        ];
    }
}
