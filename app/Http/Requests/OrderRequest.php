<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !\Auth::user()->cartContents($this->restaurant_id)->isEmpty();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'restaurant_id' => 'required|exists:restaurants,id',
            'order_type' => 'required|in:DINE_IN,PICK_UP',
            'payment_type' => 'required|in:CASH,CREDIT_CARD',
            'name' => 'required|max:100',
            'contact_number' => 'required|max:15',
            'order_date' => 'required|date_format:"Y-m-d"',
            'order_time' => 'required|date_format:"g:i A"',
            'guest_count' => 'required_if:order_type,DINE_IN|min:1',
            // 'cook_time' => 'required_if:order_type,DINE_IN|date_format:"g:i A"',
        ];

        return $rules;
    }
}
