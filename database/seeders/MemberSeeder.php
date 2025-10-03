<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    public function run()
    {
        Member::create([
            'name' => 'Jane Doe',
            'email' => 'jane@example.com',
            'household' => 'Doe Family',
            'contact' => '09123456789',
        ]);

        Member::create([
            'name' => 'John Smith',
            'email' => 'john@example.com',
            'household' => 'Smith Family',
            'contact' => '09121234567',
        ]);
    }
}

