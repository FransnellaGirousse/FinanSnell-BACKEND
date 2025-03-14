<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    protected $fillable = [
        'social_security_number',
        'nationality',
        'address',
        'date_need_by',
        'date_requested',
        'special_mailing_instruction',
        'purpose_of_travel',
        'destination',
        'location',
        'per_diem_rate',
        'daily_rating_coefficient',
        'percentage_of_advance_required',
        'total_amount',
        'additional_costs_motif',
        'additional_costs',
        'total_sum',
        'amount_requested',
        'bank',
        'branch',
        'name',
        'account_number',
        'number_of_days',
        'total_general',
        'final_total',
    ];
    public function rows()
    {
        return $this->hasMany(TravelRow::class);
    }
}
