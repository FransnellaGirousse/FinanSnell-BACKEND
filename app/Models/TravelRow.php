<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TravelRow extends Model
{
    use HasFactory;

    protected $fillable = [
        'request_in_advance_id',
        'location',
        'per_diem_rate',
        'percentage_of_advance_required',
        'number_of_days',
        'total_amount',
    ];

    public function requestInAdvance()
    {
        return $this->belongsTo(RequestInAdvance::class);
    }
    public function request()
    {
        return $this->belongsTo(Request::class);
    }
}
