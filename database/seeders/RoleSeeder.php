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
    // Créer des permissions générales
    Permission::create(['name' => 'edit_posts']);
    Permission::create(['name' => 'view_dashboard']);

    // Permissions spécifiques aux interfaces
    Permission::create(['name' => 'view_mission']);
    Permission::create(['name' => 'view_mission_reports']);
    Permission::create(['name' => 'view_request_in_advance']);
    Permission::create(['name' => 'view_purchase_request']);
    Permission::create(['name' => 'view_expense']);

    // Permissions spécifiques pour les rôles
    Permission::create(['name' => 'approve_mission_admin']);
    Permission::create(['name' => 'approve_mission_accountant']);
    Permission::create(['name' => 'approve_mission_director']);

    // Créer les rôles
    $adminRole = Role::create(['name' => 'administrator']);
    $userRole = Role::create(['name' => 'user']);
    $accountantRole = Role::create(['name' => 'accountant']);
    $directorRole = Role::create(['name' => 'director']);
    $visitorRole = Role::create(['name' => 'visitor']);

    // Assigner des permissions aux rôles
    $adminRole->givePermissionTo([
        'view_dashboard', 'edit_posts',
        'approve_mission_admin', 
    ]);

    $accountantRole->givePermissionTo([
        'view_dashboard', 'edit_posts',
        'approve_mission_accountant', 
    ]);

    $directorRole->givePermissionTo([
        'view_dashboard', 'edit_posts',
        'approve_mission_director', 
    ]);

    $userRole->givePermissionTo([
        'view_dashboard', 'edit_posts',
        'view_mission', 'view_mission_reports', 'view_request_in_advance', 'view_purchase_request', 'view_expense', // Accès aux interfaces spécifiques
    ]);

    // Le rôle "visitor" n'a pas de permissions d'action, il peut juste voir les pages
    $visitorRole->givePermissionTo([
        'view_dashboard', 'edit_posts',
        'view_mission', 'view_mission_reports', 'view_request_in_advance', 'view_purchase_request', 'view_expense',
    ]);

    // Assigner les rôles aux utilisateurs (par exemple)
    $admin = User::find(1);
    $admin->assignRole('administrator');

    $accountant = User::find(2);
    $accountant->assignRole('accountant');

    $director = User::find(3);
    $director->assignRole('director');

    $user = User::find(4);
    $user->assignRole('user');

    $visitor = User::find(5);
    $visitor->assignRole('visitor');
}

    
}
