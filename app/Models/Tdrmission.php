<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tdrmission extends Model
{
    use HasFactory;
    
     protected $table = 'create_tdr';

    protected $fillable = [
        'mission_title',
        'introduction',
        'mission_objectives',
        'planned_activities',
        'necessary_resources',
        'conclusion'
    ];
}
