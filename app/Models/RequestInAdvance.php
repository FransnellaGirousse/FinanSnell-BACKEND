<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestInAdvance extends Model
{
    use HasFactory;

    protected $fillable = [
        'social_security_number',
        'nationality',
        'address',
        'date_need_by',
        'date_requested',
        'purpose_of_travel',
        'destination',
        'additional_costs_motif',
        'additional_costs',
        'amount_requested',
        'bank',
        'branch',
        'name',
        'account_number',
        'total_general',
        'final_total',
    ];

    public function rows()
    {
        return $this->hasMany(TravelRow::class);
    }
}
