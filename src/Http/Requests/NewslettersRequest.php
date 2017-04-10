<?php

namespace Mixdinternet\Newsletters\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NewslettersRequest extends FormRequest
{
    public function rules()
    {
        if (config('mnewsletters.fields.name') !== false){
            return [
                'name' => 'required'
                , 'email' => 'required|email'
            ];
        }

        if (config('mnewsletters.fields.name') == false){
            return [
                'email' => 'required|email'
            ];
        }
    }

    public function authorize()
    {
        return true;
    }

}