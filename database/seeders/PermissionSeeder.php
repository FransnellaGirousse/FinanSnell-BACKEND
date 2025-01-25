<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Créer les permissions
        Permission::create(['name' => 'view_dashboard']);
        Permission::create(['name' => 'edit_posts']);
        
        // Permissions spécifiques aux interfaces
        Permission::create(['name' => 'view_mission']);
        Permission::create(['name' => 'view_mission_reports']);
        Permission::create(['name' => 'view_request_in_advance']);
        Permission::create(['name' => 'view_purchase_request']);
        Permission::create(['name' => 'view_expense']);
        
        // Permissions pour les approbations spécifiques
        Permission::create(['name' => 'approve_mission_admin']);
        Permission::create(['name' => 'approve_mission_accountant']);
        Permission::create(['name' => 'approve_mission_director']);
    }
}
