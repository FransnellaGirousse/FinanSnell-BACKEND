<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname', 'lastname', 'email', 'role', 'phone_number', 'address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}



