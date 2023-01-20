<?php

namespace App\Http\Requests;

use App\User;
use Illuminate\Foundation\Http\FormRequest;

class StoreUsersRequest extends FormRequest
{    
    public function rules()
    {
        return [
            'firstName'=> [
                'required',
            ],
            'email'    => [
                'required',
            ],
            'groupId' => [
                'required',
                'integer'
            ],
            'phoneNumber'  => [
                'integer',
            ],            
        ];
    }
}
