<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mission extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'traveler',
        'purpose_of_the_mission',
        'travel_data', 
        'name_of_the_hotel',
        'room_rate',
        'confirmation_number',
        'date_hotel',
        'other_details_hotel',
        'other_logistical_requirments',
        'tdr_id',
        'key_company'
    ];

    protected $casts = [
        'travel_data' => 'array', 
    ];
}
