<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuItemRequest extends FormRequest
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
        $id = $this->route('menu') ?: '';
        $rules = [
            'name' => "required|max:50",
            'categories' => 'required|array',
            'categories.*' => 'required|exists:menu_categories,id',
            'price' => 'required|numeric',
            'available' => 'boolean',
            'description' => 'required|max:255',
            'preparation' => 'required|max:255',
            'photo' => 'required|image|max:2048'
        ];
        if($id){
            $rules['photo'] = 'image|max:2048';
        }
        return $rules;
    }
}
