<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Interest extends Model {

    protected $table = 'interest'; 
    protected $fillable = array('title', 'image', 'status');

    public function scopeGetInterestsNames()
    {
        $int = $this->lists('title', 'id');
        return $int;
    }
}
