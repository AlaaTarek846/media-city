<?php

namespace App\Http\Requests\Website;

use Illuminate\Foundation\Http\FormRequest;

class MakeOrderRequest extends FormRequest
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
            'discount_coupon_id' => 'nullable|exists:discount_coupons,id',
            'address_id' => 'required|exists:addresses,id',
            'order_status_id' => 'required|exists:order_status,id',
            'discount' => 'nullable|numeric|min:0',
            'coupon_discount' => 'nullable|numeric|min:0',
            'tax_percentage' => 'nullable|numeric|min:0',
            'tax' => 'nullable|numeric|min:0',
            'shipping_price' => 'nullable|numeric|min:0',
            'sub_total' => 'nullable|numeric|min:0',
            'total' => 'nullable|numeric|min:0',
        ];
    }
}
