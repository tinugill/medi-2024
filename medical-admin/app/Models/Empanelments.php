<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empanelments extends Model
{
    use HasFactory;
    protected $fillable = [
        "id",
        "title",
        "is_deleted",
        "is_approved"
    ];
}
