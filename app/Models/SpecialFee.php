<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class SpecialFee extends Model
{
	public $timestamps = true;
    public $table = 'special_fee';
    protected $fillable = [
        'amount', 'enabled', 'user_id'
    ];

    public static function getCurrent($userId){

    	return speciaLFee::where('user_id',$userId)
    		->first()
    		;
    }

    public function user(){
        return $this->BelongsTo('App\Models\User');
    }
}
