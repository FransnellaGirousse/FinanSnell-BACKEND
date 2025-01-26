<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User; 

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
{


    // Créer les rôles
    Role::create(['name' => 'administrator']);
    Role::create(['name' => 'user']);
    Role::create(['name' => 'accountant']);
    Role::create(['name' => 'director']);
    Role::create(['name' => 'visitor']);

}

    
}
