<?php

// app/Models/AssignmentOM.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentOM extends Model
{
    use HasFactory;

    // Spécifie les colonnes qui peuvent être remplies massivement (mass assignable)
    protected $fillable = [
        'date',
        'traveler',
        'purpose_of_the_mission',
        'date_hour',
        'starting_point',
        'destination',
        'authorization_airfare',
        'fund_speedkey',
        'price',
        'name_of_the_hotel',
        'room_rate',
        'confirmation_number',
        'date_hotel',
        'other_details_hotel',
        'other_logistical_requirments',
        'tdr_id',  // ID du TDR lié
    ];

    // Relation avec le TDR
    public function tdr()
    {
        return $this->belongsTo(Tdrmission::class);
    }

     public function missionDetails()
    {
        return $this->hasMany(MissionDetail::class);
    }
}

