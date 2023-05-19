<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $table = 'comments';
    protected $primaryKey = 'id';
    protected $keytype = 'int';

    protected $fillable = [
        'user_id',
        'article_id',
        'name',
        'comment',
        'created_at',
        'updated_at',
    ];
}
