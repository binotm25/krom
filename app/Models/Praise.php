<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Praise extends Model
{
    protected $table = 'praise';
    protected $fillable = ['creation_id', 'interest_id', 'user_id', 'action', 'comment'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }
}
