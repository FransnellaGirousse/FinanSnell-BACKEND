<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Sanctum\HasApiTokens; 
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Socialite\Facades\Socialite;



class User extends Authenticatable
{
    use HasFactory, Notifiable;
     use HasApiTokens, Notifiable;
         use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
 
    protected $fillable = [
        'firstname', 
        'lastname',
        'email',
        'password', 
        'phone_number', 
        'role',
        'google_id',
        'image',
        'key_company',
        'gestion_type'
    ];



    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function getImageUrlAttribute()
    {
   
        return $this->image ? $this->image : 'https://www.w3schools.com/howto/img_avatar.png'; 
    }

    public function accounts()
    {
        return $this->hasMany(Account::class);
    }

    public function account()
    {
        return $this->hasOne(Account::class);
    }
    protected static function booted() 
    {
        static::created(function($user) {
             $user->account()->create([
                'firstname'     => $user->firstname,  
                'lastname'      => $user->lastname,
                'email'         => $user->email,
                'role'          => $user->role,
                'phone_number'  => $user->phone_number,
                'address'       => $user->address,
             ]);
        });
    }
    public function handleGoogleCallback()
{
    // Si vous utilisez stateless() car votre front gère l'authentification
    $googleUser = Socialite::driver('google')->user();

    $user = User::firstOrCreate(
        ['email' => $googleUser->getEmail()],
        [
            // Ici, vous pouvez ajuster la récupération des informations depuis Google
            'firstname' => $googleUser->getName(), // Vous pouvez séparer prénom et nom si besoin
            'lastname'  => 'Inconnu',
            'role'      => 'visiteur',
        ]
    );

    // Vérifier si le compte associé existe, sinon le créer
    if (!Account::where('email', $user->email)->exists()) {
        $user->account()->create([
            'firstname'    => $user->firstname,
            'lastname'     => $user->lastname,
            'email'        => $user->email,
            'role'         => $user->role,
            'phone_number' => $user->phone_number, 
            'address'      => $user->address,      
        ]);
    }

    // Suite de votre logique d'authentification (générer un token, rediriger, etc.)
}

}
