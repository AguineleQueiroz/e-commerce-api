<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreUpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        // change only the category name and keep the code
        if($this->isMethod('PATCH')) {
            $rules['code'] = [
                'required',
                'min:3',
                'max:6',
                // "unique:categories,code,{$this->id},id",
                Rule::unique('categories')->ignore($this->id),
            ];
            return $rules;
        }

        $rules = [
            'code' => 'required|min:3|max:6|unique:categories',
            'category' => 'required|min:3|max:45',
        ];    
 
        return $rules;
    }
}
