<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BookRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name'       => 'required|min:1',
            'author'       => 'required|min:1',
            'description' => 'required|min:3',
            'category_id' => 'required|numeric',
            'introduction' => 'max:80',
        ];
    }

    public function messages()
    {
        return [
            'name.min' => '书名必须至少一个字符',
            'author.min' => '书名必须至少一个字符',
            'description.min' => '描述内容必须至少三个字符',
        ];
    }
}
