<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\ContactUs;
use App\Models\ContactUsLog;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ContactUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ContactUs::create([
            'email' => 'Please enter your email',
            'phone' => 'Please enter the phone number ',
            'address_en' => 'Please enter the address in English',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s')
        ]);
    }
}
