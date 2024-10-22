<?php  

namespace App\Models;  

use Illuminate\Database\Eloquent\Factories\HasFactory;  
use Illuminate\Database\Eloquent\Model;  
use Illuminate\Notifications\Notifiable;  

class Register extends Model  
{  
    use HasFactory, Notifiable;  

    protected $table = 'users';  

    protected $fillable = [  
        'firstname',  
        'lastname',  
        'email',  
        'password',  
        'phone_number',  
        'role',  
    ];  
}