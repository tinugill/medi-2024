<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;
    protected $fillable = [
        "meeting_id",
        "host_id",
        "host_email",
        "topic",
        "secret",
        "type",
        "start_url",
        "join_url",
        "occurrences",
        "password"
    ];
}
