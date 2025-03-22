<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supporting extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'description',
        'name',
        'file_name',
        'file_path',
    ];
}
