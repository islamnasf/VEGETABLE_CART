<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class productRequest extends FormRequest
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
            'name'=>'required|alpha',
            'description'=>'required',
            'code'=>'required',
            'price'=>'required',
            'category_id'=>'required',
            'weight'=>'required',
            'discount'=>'required',
            'image' => 'required|image|max:2048|mimes:jpeg,png,jpg,webp',
            'photo.*'=>'required|image|max:2048|mimes:jpeg,png,jpg,webp',
        ];
    }
}
