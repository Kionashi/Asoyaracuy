<?php

namespace App\Models;

class Poll extends RDNModel
{
    public $timestamps = false;
    public $table = 'poll';
    protected $fillable = ['enabled', 'end_date', 'end_date', 'image', 'start_date', 'title'];

    public function pollOptions()
    {
        return $this->hasMany('App\Models\PollOption');
    }
    
}
