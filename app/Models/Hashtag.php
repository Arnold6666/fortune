<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Article;

class Hashtag extends Model
{
    use HasFactory;
    protected $table = 'hashtags';
    protected $primaryKey = 'id';
    protected $keytype = 'int';
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
    ];

    public function articles()
    {
        return $this->belongsToMany(Article::class, 'article_hashtags', 'hashtag_id', 'article_id');
    }
}
