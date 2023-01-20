<?php

namespace App\Http\Requests;

use App\Workouts;
use Illuminate\Foundation\Http\FormRequest;

class UpdateWorkoutsRequest extends FormRequest
{    
    public function rules()
    {
        return [     
            'name' => [
                'required',
            ],
            'level' => [
                'required'
            ],  
            'userId' => [
                'required',
            ],
            'duration' => [
                'required'
            ], 
            'quantity' => [
                'required',
            ],
            'price' => [
                'required'
            ],                
        ];
    }
}
