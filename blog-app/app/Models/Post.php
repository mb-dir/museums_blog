<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'title',
        'content',
        'tags',
        'date',
        'user_id',
    ];

    public function user()//relationship in DB
    {
        return $this->belongsTo(User::class);
    }
}
