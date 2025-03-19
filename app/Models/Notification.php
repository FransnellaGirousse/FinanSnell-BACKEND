<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
     protected $fillable = [
        'id_user_request',
        'id_user_offer',
        'date_requested',
        'read',
        'type',
        'id_type_request',
    ];

}
