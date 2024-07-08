<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\PermissionRegistrar;

class PermissionsDemoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
      app()[PermissionRegistrar::class]->forgetCachedPermissions();
      Permission::create(['name' => 'add adherent']);
      Permission::create(['name' => 'add banque']);
      Permission::create(['name' => 'add transaction']);
      Permission::create(['name' => 'delete adherent']);
      Permission::create(['name' => 'delete banque']);
      Permission::create(['name' => 'delete transaction']);
      Permission::create(['name' => 'edit adherent']);
      Permission::create(['name' => 'edit banque']);
      Permission::create(['name' => 'edit transaction']);
      Permission::create(['name' => 'manage remises']);
      Permission::create(['name' => 'delete remises']);
      Permission::create(['name' => 'manage users']);
      Permission::create(['name' => 'show adherent']);
      Permission::create(['name' => 'show banque']);
      Permission::create(['name' => 'show dashboard']);
      Permission::create(['name' => 'show transaction']);

      $role = Role::create(['name' => 'super-admin']);
      $role->givePermissionTo(Permission::all());

      $role_2 = Role::create(['name' => 'directeur-general']);
      $role_2->givePermissionTo('show dashboard');

      $role_3 = Role::create(['name' =>'directrice-com']);
      $role_3->givePermissionTo(Permission::all());

      $role_4 = Role::create(['name' =>'manager']);
      $role_4->givePermissionTo(['add adherent','add transaction','delete adherent','delete transaction','edit transaction','edit adherent','manage remises','show adherent','show transaction','delete remises']);

      $role_5 = Role::create(['name' => 'comptable']);
      $role_5->givePermissionTo(['add transaction','show transaction','manage remises']);




    }
}
