<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserInterest extends Model {

    protected $table = 'user_interests';
    protected $fillable = array('user_id', 'interest_ids');

    public function scopeInterestIds($query, $id)
    {
        $userInterest = $query->whereUser_id($id)->pluck('interest_ids')->first();
        $userInterest = explode(',', $userInterest);
        return $userInterest;
    }
}
