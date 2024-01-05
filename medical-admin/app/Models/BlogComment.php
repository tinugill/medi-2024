<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BlogComment extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'blog_id',
        'name',
        'email',
        'comment',
        'is_deleted'
    ];
}
