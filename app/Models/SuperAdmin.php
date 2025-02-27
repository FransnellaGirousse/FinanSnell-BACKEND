<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;

class SuperAdmin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = ['name', 'email', 'password'];

    protected $hidden = ['password'];

    protected $casts = ['password' => 'hashed'];

    // Méthode pour créer un Super Admin
    public static function createSuperAdmin()
    {
        // Vérifier si un Super Admin existe déjà
        if (!self::where('email', 'admin@exemple.com')->exists()) {
            self::create([
                'name' => 'Admin Principal',
                'email' => 'admin@exemple.com',
                'password' => Hash::make('motdepasse123'),
            ]);
        }
    }
}
