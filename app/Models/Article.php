<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Hashtag;


class Article extends Model
{
    use HasFactory;

    protected $table = 'articles';
    protected $primaryKey = 'id';
    protected $keytype = 'int';

    protected $fillable = [
        'name',
        'user_id',
        'title',
        'content',
        'image',
        'views',
        'created_at',
        'updated_at',
    ];

    public function hashtags()
    {
        return $this->belongsToMany(Hashtag::class, 'article_hashtags', 'article_id', 'hashtag_id');
    }
}
