<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $hidden = ['createdAt', 'updatedAt'];

    protected $fillable = [
        'userId',
        'token', 
        'platform',               
    ];
}
