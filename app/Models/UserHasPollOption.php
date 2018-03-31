<?php

namespace App\Models;

class UserHasPollOption extends RDNModel
{
    public $timestamps = false;
    public $table = 'user_has_poll_option';
    protected $fillable = ['user_id', 'poll_option_id'];

    public function pollOption()
    {
        return $this->belongsTo('App\Models\PollOption');
    }
    
    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
