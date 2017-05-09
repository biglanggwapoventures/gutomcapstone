<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MenuCategoryRequest extends FormRequest
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
        $rules = [
            'name' => 'required|unique:menu_categories,name|max:20',
            'description' => 'required|max:100'
        ];
        if($id = $this->route('menu_category')){
            $rules['name'] = "required|unique:menu_categories,name,{$id}|max:20";
        }
        return $rules;
    }
}
