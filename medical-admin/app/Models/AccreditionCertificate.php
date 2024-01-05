<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccreditionCertificate extends Model
{
    use HasFactory;
    protected $fillable = [
        'parent_id',
        'doc_name',
        'proof', 
        'is_deleted',
    ];
}
