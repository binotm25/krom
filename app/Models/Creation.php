<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Creation extends Model {

    protected $table = 'user_creation'; 
    protected $fillable = array('user_id', 'title', 'location', 'interest_id', 'description');

    public function interest() {
        return $this->belongsTo('App\Models\Interest');
    }

    public function user() {
        return $this->belongsTo('App\Models\User');
    }

    public function collaborate()
    {
        return $this->hasMany('App\Models\Collaborate', 'user_creation_id', 'id');
    }

    public function userCreationImages() {
        return $this->hasMany('App\Models\UserCreationImages', 'user_creation_id');
    }

    public function country()
    {
        return $this->hasManyThrough('App\Models\Country', 'App\Models\User', 'country_code', 'country_code', 'user_id');
    }

    public function praise()
    {
        return $this->hasMany('App\Models\Praise');
    }
}
