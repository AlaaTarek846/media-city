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
     * @return array
     */
    public function rules()
    {
        return [
            'title' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
            'address' => 'required|string|max:255',
            'area_id' => 'required|exists:areas,id',
            'building_number' => 'nullable|string|max:255',
            'floor_number' => 'nullable|string|max:255',
            'apartment_number' => 'nullable|string|max:255',
            'distinctive_mark' => 'nullable|string|max:255',
            'is_primary' => 'nullable',
        ];
    }
}
