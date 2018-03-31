<?php

namespace App\Models;

class PollOption extends RDNModel
{
    public $timestamps = false;
    public $table = 'poll_option';
    protected $fillable = ['title', 'poll_id'];

    public function poll()
    {
        return $this->belongsTo('App\Models\Poll');
    }
    
    public function userHasPollOptions()
    {
        return $this->hasMany('App\Models\UserHasPollOption');
    }
    
    public static function findAll($parameters) {
        // Default parameters
        $parameters = is_array($parameters) ? $parameters : array();
        
        // Extract parameters
        $pollId = array_key_exists('pollId', $parameters) ? $parameters['pollId'] : null;
        $userHasPollOption = array_key_exists('userHasPollOption', $parameters) ? $parameters['userHasPollOption'] : null;
        
        // Prepare query
        $pollOptionQuery = PollOption::select();
        
        // Filter by poll id
        if($pollId) {
            $pollOptionQuery->where('poll_id', $pollId);
        }
        
        // Load poll potions
        if($userHasPollOption) {
            $pollOptionQuery->with('userHasPollOptions');
        }
        
        return $pollOptionQuery->get();
    }
    
}
