<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Models\Permission;
use App\Models\Role;
use App\Traits\WithTruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;

class RoleSeeder extends Seeder
{

    use WithTruncateTable;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $this->truncate('roles');
        $this->createAdminRole();
        $this->createDriverRole();
        $this->createPassengerRole();
        $this->createManagerRole();
    }

    public function createRole(RoleName $role, Collection $permissions): void
    {
        $newRole = Role::create(['name' => $role->value]);
        $newRole->permissions()->sync($permissions);
    }

    public function createAdminRole(): void
    {
        $permissions = Permission::query()
            ->where('name', 'like', 'permission.%')
            ->orWhere('name', 'like', 'role.%')
            ->orWhere('name', 'like', 'user.%')
            ->pluck('id');


        $this->createRole(RoleName::ADMIN, $permissions);
    }

    public function createDriverRole(): void
    {
        $permissions = Permission::query()
            ->where('name', 'like', 'user.%')
            ->pluck('id');


        $this->createRole(RoleName::DRV, $permissions);
    }

    public function createPassengerRole(): void
    {
        $permissions = Permission::query()
            ->where('name', 'like', 'user.%')
            ->pluck('id');


        $this->createRole(RoleName::PSNG, $permissions);
    }
    public function createManagerRole(): void
    {
        $permissions = Permission::query()
            ->where('name', 'like', 'vehicle.%')
            ->orWhere('name', 'like', 'driver.%')
            ->pluck('id');


        $this->createRole(RoleName::MGR, $permissions);
    }

}
