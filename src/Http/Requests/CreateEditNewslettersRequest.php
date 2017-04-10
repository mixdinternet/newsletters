<?php

namespace Mixdinternet\Newsletters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEditNewslettersRequest extends FormRequest
{
    public function rules()
    {
        return [
            'email' => 'required'
            /* TODO: Validar */
            #, 'name' => 'required|max:150'
        ];
    }

    public function authorize()
    {
        return true;
    }
}