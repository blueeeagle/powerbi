<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class Users extends Authenticatable
{   
    use Notifiable, HasApiTokens;

    const CREATED_AT = 'createdAt';
    const UPDATED_AT = 'updatedAt';

    protected $hidden = ['createdAt', 'updatedAt', 'password', 'remember_token', 'activation_token'];

    protected $fillable = [
        'firstName',
        'lastName',    
        'email',
        'password',
        'groupId',
        'image',
        'bio',
        'phoneNumber',
        'birthDate',
        'gender',
        'remember_token'
    ];

    public function category()
    {
        return $this->belongsTo('App\UsersCategories', 'userId','id');
    }
}
