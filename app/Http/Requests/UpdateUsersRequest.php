<?php

namespace App\Http\Requests;

use App\Users;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUsersRequest extends FormRequest
{    
    public function rules()
    {
        return [     
            'firstName' => [
                'required',
            ],
            'email' => [
                'required','email'
            ],                   
        ];
    }
}
