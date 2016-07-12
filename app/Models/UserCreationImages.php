<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserCreationImages extends Model {

    protected $table = 'user_creation_images';
    protected $fillable = array('user_creation_id', 'image', 'featured');

    public function creation()
    {
        return $this->belongsTo('App\Models\Creation', 'user_creation_id', 'id');
    }
}
