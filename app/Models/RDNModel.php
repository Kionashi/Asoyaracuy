<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RDNModel extends Model
{
    public function __isset($key)
    {
        return (isset($this->attributes[self::toSnakeCase($key)]) || isset($this->relations[$key])) ||
        ($this->hasGetMutator($key) && ! is_null($this->getAttributeValue($key)));
    }
    
    public function __unset($key)
    {
        unset($this->attributes[self::toSnakeCase($key)], $this->relations[$key]);
    }
    
    public function getAttribute($key)
    {
        if (array_key_exists($key, $this->relations)) {
            return parent::getAttribute($key);
        } else {
            return parent::getAttribute(self::toSnakeCase($key));
        }
    }
    
    public function setAttribute($key, $value)
    {
        return parent::setAttribute(self::toSnakeCase($key), $value);
    }
    
    private static function toSnakeCase($key) 
    {
        return snake_case($key);
    }
    
}