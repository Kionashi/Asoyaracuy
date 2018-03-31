<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
    
    public $timestamps = false;
    public $table = 'user';
    protected $fillable = [
        'activation_code', 
        'activation_date', 
        'activation_ip_address', 
        'bbm_pin', 
        'birth_date', 
        'city', 
        'email', 
        'enabled', 
        'first_name',
        'gender',
        'image',
        'last_name',
        'password',
        'phone',
        'recover_code',
        'recover_date',
        'recover_ip_address',
        'register_date',
        'register_ip_address',
        'status',
        'telegram_user',
        'username',
        'country_id'
    ];

    public function contacts()
    {
        return $this->hasMany('App\Models\Contact');
    }
    
    public function country()
    {
        return $this->belongsTo('App\Models\Country');
    }
    
    public function userNotification()
    {
        return $this->belongsTo('App\Models\UserNotification');
    }
    
    // Virtual attributes
    public function getContactCountAttribute() {
        return $this->contacts ? $this->contacts->count() : 0;
    }
}
