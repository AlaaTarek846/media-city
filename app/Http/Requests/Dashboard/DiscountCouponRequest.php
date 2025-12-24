<?php

namespace App\Http\Requests\Dashboard;

use Illuminate\Foundation\Http\FormRequest;

class DiscountCouponRequest extends FormRequest
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
            "translations"         => "nullable|array",
            "translations.*.title" => "required|string",
            "translations.*.description" => "nullable|string",
            "code" => "required|string|unique:discount_coupons,code," . $this->route('discount_coupon'),
            "type"                 => "required|in:fixed,percentage",
            "value"                => "required|numeric|min:0",
            "user_count"           => "required|numeric|min:0",
            "start_date"          => "nullable|date_format:Y-m-d",
            "expire_date"         => "nullable|date_format:Y-m-d|after_or_equal:start_date",
            "greater_than"        => "nullable|numeric|min:0",
            "status" =>  "required|boolean",
        ];
    }
}
