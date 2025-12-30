<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProfileRequest extends FormRequest
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
     * Rules vary based on user_type
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userType = $this->input('user_type', auth('user')->user()->user_type ?? 'person');
        
        $rules = [
            'name' => 'required|string|max:255',
            'mobile' => 'nullable|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'link' => 'nullable|url|max:1000',
        ];

        // Add file validation rules based on user type
        if ($userType === 'person' || $userType === 'studio') {
            $rules['id_card_front'] = 'nullable|image|mimes:jpeg,jpg,png|max:2048';
            $rules['id_card_back'] = 'nullable|image|mimes:jpeg,jpg,png|max:2048';
        }

        if ($userType === 'company') {
            $rules['commercial_register_image'] = 'nullable|image|mimes:jpeg,jpg,png|max:2048';
            $rules['tax_card_image'] = 'nullable|image|mimes:jpeg,jpg,png|max:2048';
        }

        return $rules;
    }

    /**
     * Get custom validation messages.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => __('messages.Full name is required'),
            'name.string' => __('messages.Full name must be a valid text'),
            'name.max' => __('messages.Full name must not exceed 255 characters'),
            'mobile.string' => __('messages.Mobile number must be a valid text'),
            'mobile.max' => __('messages.Mobile number must not exceed 20 characters'),
            'whatsapp.string' => __('messages.WhatsApp number must be a valid text'),
            'whatsapp.max' => __('messages.WhatsApp number must not exceed 20 characters'),
            'facebook_link.url' => __('messages.Facebook link must be a valid URL'),
            'instagram_link.url' => __('messages.Instagram link must be a valid URL'),
            'linkedin_link.url' => __('messages.LinkedIn link must be a valid URL'),
            'id_card_front.image' => __('messages.National ID front must be an image'),
            'id_card_front.mimes' => __('messages.National ID front must be jpeg, jpg, or png'),
            'id_card_front.max' => __('messages.National ID front must not exceed 2MB'),
            'id_card_back.image' => __('messages.National ID back must be an image'),
            'id_card_back.mimes' => __('messages.National ID back must be jpeg, jpg, or png'),
            'id_card_back.max' => __('messages.National ID back must not exceed 2MB'),
            'commercial_register_image.image' => __('messages.Commercial register must be an image'),
            'commercial_register_image.mimes' => __('messages.Commercial register must be jpeg, jpg, or png'),
            'commercial_register_image.max' => __('messages.Commercial register must not exceed 2MB'),
            'tax_card_image.image' => __('messages.Tax card must be an image'),
            'tax_card_image.mimes' => __('messages.Tax card must be jpeg, jpg, or png'),
            'tax_card_image.max' => __('messages.Tax card must not exceed 2MB'),
        ];
    }
}
