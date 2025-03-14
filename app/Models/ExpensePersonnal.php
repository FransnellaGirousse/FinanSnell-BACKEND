<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExpensePersonnal extends Model
{
    use HasFactory;
    protected $table = 'expense_personnals'; 
    protected $fillable = ['description', 'amount', 'category', 'date'];
}
