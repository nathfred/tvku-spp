<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Assignment;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        // DIRECTOR
        User::create([
            'name' => 'Dr. Guruh Fajar Shidik, S.Kom, M.CS',
            'role' => 'director',
            'gender' => 'male',
            'email' => 'director@tvku.tv',
            'email_verified_at' => now(),
            'password' => bcrypt('123123'),
            'remember_token' => Str::random(10),
        ]);

        // EMPLOYEE
        User::create([
            'name' => 'Upik',
            'role' => 'employee',
            'gender' => 'female',
            'email' => 'upik@tvku.tv',
            'email_verified_at' => now(),
            'password' => bcrypt('123123'),
            'remember_token' => Str::random(10),
        ]);
        // EMPLOYEE
        User::create([
            'name' => 'Intan',
            'role' => 'employee',
            'gender' => 'female',
            'email' => 'intan@tvku.tv',
            'email_verified_at' => now(),
            'password' => bcrypt('123123'),
            'remember_token' => Str::random(10),
        ]);

        Assignment::factory(5)->create();
    }
}