<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\Rule;

class CartRequest extends FormRequest
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
            'menu_id' => 'required|exists:menus,id',
        ];
        if(in_array(strtolower($this->method()), ['patch', 'post'])){
           $rules['quantity'] = 'required|integer|min:1';
        }
        if($this->route('cart')){
            $rules['menu_id'] = ['required', Rule::exists('carts')->where(function ($query) {
                $query->where([
                    ['user_id', '=', \Auth::id()],
                    ['id','=',$this->route('cart')]
                ]);
            })];
        }
        return $rules;
    }

    protected function formatErrors(Validator $validator)
    {
        return $validator->errors()->all();
    }
}
