<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ranking extends Model
{
    use HasFactory;

    public function users()
    {
        return $this->belongsToMany('App\Models\Ranking', 'ranking_user', 'ranking_id', 'user_id');
    }
}
