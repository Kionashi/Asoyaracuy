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
        'balance', 
        'email', 
        'enabled', 
        'house', 
        'password',
        'phone',
        'status',
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

    public function specialFee() {

         return $this->hasOne('App\Models\SpecialFee');
    }

    // Virtual attributes
    public function getContactCountAttribute() {
        return $this->contacts ? $this->contacts->count() : 0;
    }
}
