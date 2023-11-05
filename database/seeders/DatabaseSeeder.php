<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\User::factory(10)->create();

        \App\Models\User::create([
            'name' => 'Admin',
            'email' => 'admin@mail.com',
            'password' => Hash::make('admin123'),
            'admin' => true
        ]);

        \App\Models\User::create([
            'name' => 'Officer',
            'email' => 'officer@mail.com',
            'password' => Hash::make('officer123')
        ]);

        $this->call([
            AttendanceSeeder::class      
        ]);
    }
}
