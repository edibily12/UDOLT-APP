<?php

namespace Database\Seeders;

use App\Enums\RoleName;
use App\Enums\UserType;
use App\Models\Role;
use App\Models\User;
use App\Traits\WithTruncateTable;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{

    use WithTruncateTable;
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
//        $this->truncate('users');
        $this->createAdminUser();
        $this->createDriverUser();
        $this->createPassengerUser();
        $this->createManagerUser();
    }

    public function createAdminUser(): void
    {
        User::create([
            'name' => 'Admin User',
            'type' => UserType::ADMIN->value,
            'email' => 'admin@admin.com',
            'password' => bcrypt('password'),
        ])->roles()->sync(Role::where('name', RoleName::ADMIN->value)->first());
    }
    public function createManagerUser(): void
    {
        User::create([
            'name' => 'Manager User',
            'type' => UserType::MGR->value,
            'email' => 'mgr@mgr.com',
            'password' => bcrypt('password'),
        ])->roles()->sync(Role::where('name', RoleName::MGR->value)->first());
    }

    public function createDriverUser(): void
    {
        User::create([
            'name' => 'Staff User',
            'type' => UserType::DRV->value,
            'email' => 'staff@staff.com',
            'password' => bcrypt('password'),
        ])->roles()->sync(Role::where('name', RoleName::DRV->value)->first());
    }

    public function createPassengerUser(): void
    {
        $user = User::create([
            'name' => 'Student User',
            'type' => UserType::PSNG->value,
            'email' => 'st@st.com',
            'password' => bcrypt('password'),
        ]);

        $user->roles()->sync(Role::where('name', RoleName::PSNG->value)->first());
    }


}
