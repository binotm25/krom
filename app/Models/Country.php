<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Country extends Model {

    protected $table = 'country';
    protected $dateFormat = 'U';

    public function user()
    {
        return $this->hasMany('App\Models\User', 'country_code', 'country_code');
    }
}
