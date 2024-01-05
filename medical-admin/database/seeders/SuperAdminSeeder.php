<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SuperAdmin;
use Illuminate\Support\Facades\Hash;

class SuperAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      SuperAdmin::create([
            'name' => 'Super Admin',
            'email' => 'superadmin@gmail.com',
            'mobile' => '1234567890',
            'password' => Hash::make('12345678')
        ]);
    }
}
