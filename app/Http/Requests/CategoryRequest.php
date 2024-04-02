<?php

namespace App\Http\Requests;

use App\Rules\Filter;
use Illuminate\Foundation\Http\FormRequest;

class CategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    ///if the authenticated user is authorized to perform the request.
    ///This method should return true if the user is authorized and false otherwise.
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
//        $id = $this->route('category');
        return [
            'name'=>[
              'required',
              'string',
              'min:3',
              'max:255',
//                function ($attribute,$value,$fails) {
//                    if (strtolower($value)=='laravel'){
//                        $fails("This name is Forbidden!");
//                    }
//                }
//            new Filter('laravel'),
            new Filter(['laravel','html']),
            ],
//            'name'=>'required|string|min:3|max:255', //255 number of characters
            'parent_id'=>[
                'nullable',
                'int',
                'exists:categories,id',

            ],
            'image'=>[
                'image',
                'max:1048576', //1048576 bytes
                'dimensions:min_width=100,min_height=100',
            ],
            'status'=>'in:active,archived',
        ];
    }

    public function messages()
    {
        return [
            'name.required'=>'you should enter this field!'
        ];
    }
}
