<?php

namespace App\Http\Requests;

use App\Users;
use Illuminate\Foundation\Http\FormRequest;

class UpdatePasswordRequest extends FormRequest
{    
    public function rules()
    {
        return [     
            'password' => [
                'required',
            ],
            'cpassword' => [
                'required'
            ],                   
        ];
    }
}
