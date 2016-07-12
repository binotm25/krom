<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;

class User extends Model {

    protected $table = 'user';
    protected $fillable = array('name', 'email', 'password', 'my_story', 'my_work_my_life', 'city', 'zip_code', 'country_code', 'status', 'activation_code', 'last_login', 'profile_pic', 'cover_pic');

    public function interest()
    {
        return $this->hasMany('App\Models\Interest');
    }

    public function creation()
    {
        return $this->hasMany('App\Models\Creation', 'user_id', 'id');
    }

    public function country()
    {
        return $this->belongsTo('App\Models\Country', 'country_code', 'country_code');
    }

    public function scopeUserInterest()
    {
        $interestTitle = $this->UserInterest->InterestIds($this->AuthUser->id);
        $userInterest = explode(',', $interestTitle);
        $interests = $this->Interest->whereIn('id', $userInterest)->get();
    }

    public function collaboration()
    {
        return $this->hasMany('App\Models\Collaborate', 'user_mapped', 'id');
    }

    public function praise()
    {
        return $this->hasMany('App\Models\Praise');
    }
}
