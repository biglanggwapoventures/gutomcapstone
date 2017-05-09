<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdvertisementRequest extends FormRequest
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
        $id = $this->route('advertisement');
        $rules = [
            'title' => "required|max:50",
            'description' => 'required|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'photo' => 'required|image|max:2048'
        ];
        if($id){
            $rules['photo'] = 'image|max:2048';
        }
        return $rules;
    }
}
