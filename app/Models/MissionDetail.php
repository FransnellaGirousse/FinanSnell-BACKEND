<?php

// app/Models/MissionDetail.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MissionDetail extends Model
{
    use HasFactory;

    // Spécifie les colonnes qui peuvent être remplies massivement (mass assignable)
    protected $fillable = [
        'assignment_om_id',  // ID de l'AssignmentOM lié
        'date_hour',
        'starting_point',
        'destination',
        'authorization_airfare',
        'fund_speedkey',
        'price',
    ];

    // Relation avec l'AssignmentOM
    public function assignmentOM()
    {
        return $this->belongsTo(AssignmentOM::class);
    }
}
