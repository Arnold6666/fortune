<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article_hashtag extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'article_id',
        'hashtag_id',
    ];
}
