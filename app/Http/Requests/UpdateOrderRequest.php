<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class UpdateOrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
       return \Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'menu_id' => ['required', Rule::exists('order_lines')->where(function ($query) {
                $query->where('user_id', \Auth::id())
                    ->where('order_id', $this->route('order'));
            })],
            'quantity' => 'required|integer|min:1'
        ];

        return $rules;
    }
    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }

}
