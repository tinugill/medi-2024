<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'apn_id',
        'reported_by',
        'user_id',
        'message',
        'status',
        'is_deleted'
    ];
}
