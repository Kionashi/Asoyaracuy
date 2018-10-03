<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserOperation extends Model
{
	public $timestamps = true;
    public $table = 'user_operations';
    protected $fillable = [
        'amount', 'concept', 'details','type', 'user_id'
    ];
}
