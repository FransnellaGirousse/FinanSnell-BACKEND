<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionReport extends Model
{
    use HasFactory;
    protected $fillable = [
        'date',
        'object',
        'mission_objectives',
        'mission_location',
        'next_steps',
        'point_to_improve',
        'strong_points',
        'recommendations',
        'progress_of_activities',
        'name_of_missionary',
    ];
}
