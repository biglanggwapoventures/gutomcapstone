<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Auth;

class RestaurantDetailsRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return !Auth::user()->hasRestaurant();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = [
            'name' => 'required|unique:restaurants|max:50',
            'address' => 'required|max:255',
            'contact_number' => 'required|max:255',
            'description' => 'required|max:255',
            'categories' => 'required|array',
            'categories.*' => 'required|exists:categories,id',
            'logo' => 'required|image|max:2048'
        ];
        return $rules;
    }
}
