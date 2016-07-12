<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Collaborate extends Model
{
    protected $table = 'collaborate';
    protected $fillable = [
        'user_creation_id', 'user_mapped', 'message'
    ];

    protected $dates = [
        'created_on'
    ];

    public function creation()
    {
        return $this->belongsTo('App\Models\Creation', 'user_creation_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\User', 'user_mapped', 'id');
    }
}
