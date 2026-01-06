<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $view = Permission::firstOrCreate(['name' => 'view']);
        $edit = Permission::firstOrCreate(['name' => 'edit']);

        $viewer = Role::firstOrCreate(['name' => 'viewer']);
        $editor = Role::firstOrCreate(['name' => 'editor']);

        $viewer->givePermissionTo($view);
        $editor->givePermissionTo([$view, $edit]);
    }
}
