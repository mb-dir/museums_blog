<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Ranking extends Model {
    use HasFactory;

    public function users() {
        return $this->belongsToMany($this, 'ranking_user', 'ranking_id', 'user_id');
    }
}
