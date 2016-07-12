<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailConfirm extends Model
{
    protected $table = 'email_confirm';
    protected $fillable = [
        'email', 'code'
    ];

}
