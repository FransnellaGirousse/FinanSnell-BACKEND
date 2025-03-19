<?php

// app/Models/AssignmentOM.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentOM extends Model
{
    use HasFactory;
    protected $table = 'assignment_oms';
    protected $fillable = [
        'date',
        'traveler',
        'purpose_of_the_mission',
        'name_of_the_hotel',
        'room_rate',
        'confirmation_number',
        'date_hotel',
        'other_details_hotel',
        'other_logistical_requirments',
    ];

    public function missions()
    {
        return $this->belongsTo(Tdrmission::class);
    }

     public function missionDetails()
    {
        return $this->hasMany(MissionDetail::class);
    }
}

