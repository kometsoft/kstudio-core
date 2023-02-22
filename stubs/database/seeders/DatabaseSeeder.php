<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->command->info('Seeding data...');
        
        \App\Models\User::updateOrCreate(
            ['email' => 'admin@domain.com'],
            [
                'id'                => 1,
                'name'              => 'Pentadbir Sistem',
                'ic_no'             => '100000000000',
                'enabled'           => true,
                'email_verified_at' => now(),
                'password'          => '$2y$10$zGUQ/XnUy.foIFzxlHCr8eb4wYz4ovxVYGtfwqiHRKa0R.JbMRPBG', // password
                'remember_token'    => Str::random(10), 
            ]);

        \App\Models\User::updateOrCreate(
            ['email' => 'pegawai@domain.com'],
            [
                'id'                => 2,
                'name'              => 'Pegawai',
                'ic_no'             => '200000000000',
                'enabled'           => true,
                'email_verified_at' => now(),
                'password'          => '$2y$10$zGUQ/XnUy.foIFzxlHCr8eb4wYz4ovxVYGtfwqiHRKa0R.JbMRPBG', // password
                'remember_token'    => Str::random(10), 
            ]);
        
        $this->call([
            RolesAndPermissionsSeeder::class,
            SettingSeeder::class,
        ]);
    }
}
