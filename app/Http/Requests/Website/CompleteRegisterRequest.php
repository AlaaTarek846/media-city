<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class CompleteRegisterRequest extends FormRequest
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
            'category_id' => 'required|exists:categories,id',
            'area_id' => 'nullable|exists:areas,id',
            'preferred_hotel' => 'nullable',
            'number_of_persons' => 'nullable', 
            'preferred_room_type' => 'nullable|in;Single Room,Double Roome,Triple Room,Quad Room',
            'age_category_id' => 'required',
            'shirt_type' => 'required|in:f,v,h',
            'shirt_color' => 'required|in:red,maroon,green,white,blue,lightBlue,yellow,black,grey,brown,purple,orange,pink,gold',
            'secondary_color' => 'required|in:red,maroon,green,white,blue,lightBlue,yellow,black,grey,brown,purple,orange,pink,gold',
            'trousers_color' => 'required|in:red,maroon,green,white,blue,lightBlue,yellow,black,grey,brown,purple,orange,pink,gold',
            'club_country_id' => 'required',
            'club_name' => 'required',
            'club_city' => 'required',
            'club_postal_code' => 'required',
            'street_and_number' => 'required',
            'postal_code' => 'required',
            'city' => 'required',
            'tournament_information' => 'required',
            'tournament_regulations' => 'required',
            'general_conditions' => 'required',
            'child_safety_policy' => 'required',
        ];
    }
}
