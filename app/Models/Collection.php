<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    public $timestamps = true;
    public $table = 'collection';
    protected $fillable = [
        'date', 'newest', 'fee_id'
    ];

    public static function getNewest(){

    	$collection = Collection::where('newest',true)->first();

    	return $collection;
    }
}
