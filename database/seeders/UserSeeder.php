<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Super Admin User :
        // ===========================================================================
        User::create([
            'name_en' => 'Super Admin',
            'username' => 'super_admin',
            'email' => 'admin@admin.com',
            'phone' => '0799999999',
            'password' => Hash::make('12345678'),
            'user_status' => 2, // Active
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_by' => 1,
        ]);

        // Customer User :
        // ===========================================================================
        Customer::create([
            'name_en' => 'Customer 1',
            'username' => 'customer_1',
            'email' => 'customer_1@smartzone.com',
            'phone' => '0799994999',
            'password' => Hash::make('12345678'),
            'user_status' => 2, // Active
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_by' => 1,
        ]);

        // Customer User :
        // ===========================================================================
        Customer::create([
            'name_en' => 'Customer 2',
            'username' => 'customer_2',
            'email' => 'customer_2@smartzone.com',
            'phone' => '0799994919',
            'password' => Hash::make('12345678'),
            'user_status' => 2, // Active
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'created_by' => 1,
        ]);
    }
}
