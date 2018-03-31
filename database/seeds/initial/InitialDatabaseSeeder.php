<?php

use Illuminate\Database\Seeder;

class InitialDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call(InitialConfigItemSeeder::class);
        $this->call(InitialAdminUserPermissionSeeder::class);
        $this->call(InitialAdminUserRoleSeeder::class);
        $this->call(InitialAdminUserSeeder::class);
    }
}
