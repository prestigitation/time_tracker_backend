<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required|string|min:2|max:255|',
            'description' => 'required|string|min:2|max:255|',
        ];
    }

    public function all($keys = null){
        if(empty($keys)){
            return parent::json()->all();
        }

        return collect(parent::json()->all())->only($keys)->toArray();
    }
}