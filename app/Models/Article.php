<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    protected $table = 'news';
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
}
