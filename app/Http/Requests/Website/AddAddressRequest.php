<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class AddAddressRequest extends FormRequest
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
     * Rules match the addresses table structure:
     * - name: nullable string (recipient name)
     * - title: required string (address title/label)
     * - address: required string (full address)
     * - area_id: required foreign key to areas table
     * - lat: required numeric (latitude from map)
     * - lng: required numeric (longitude from map)
     * - is_primary: boolean (default false)
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'address' => 'required|string|max:500',
            'area_id' => 'required|exists:areas,id',
            'lat' => 'required|numeric|between:-90,90',
            'lng' => 'required|numeric|between:-180,180',
            'is_primary' => 'nullable|boolean',
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
            'title.required' => __('messages.Address title is required'),
            'title.string' => __('messages.Address title must be a valid text'),
            'title.max' => __('messages.Address title must not exceed 255 characters'),
            'address.required' => __('messages.Full address is required'),
            'address.string' => __('messages.Full address must be a valid text'),
            'address.max' => __('messages.Full address must not exceed 500 characters'),
            'area_id.required' => __('messages.Area selection is required'),
            'area_id.exists' => __('messages.Selected area is invalid'),
            'lat.required' => __('messages.Please select a location on the map'),
            'lat.numeric' => __('messages.Latitude must be a valid number'),
            'lat.between' => __('messages.Latitude must be between -90 and 90'),
            'lng.required' => __('messages.Please select a location on the map'),
            'lng.numeric' => __('messages.Longitude must be a valid number'),
            'lng.between' => __('messages.Longitude must be between -180 and 180'),
            'is_primary.boolean' => __('messages.Primary address must be true or false'),
        ];
    }
}
