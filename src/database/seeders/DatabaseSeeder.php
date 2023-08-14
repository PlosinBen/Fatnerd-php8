<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
//         \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Ben',
            'account' => 'plosinben',
            'password' => password_hash('12345', PASSWORD_DEFAULT)
        ]);
    }
}
