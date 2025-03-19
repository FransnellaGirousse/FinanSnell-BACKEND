<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    protected $table = 'role';

    protected $fillable = ['name', 'id_companies', 'key'];

    // Relation avec Company (chaque rôle peut être associé à une entreprise)
    public function company()
    {
        return $this->belongsTo(Company::class, 'id_companies');
    }
}
