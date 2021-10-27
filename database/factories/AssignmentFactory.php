<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Assignment;
use Faker\Factory as Faker;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class AssignmentFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Assignment::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $faker = Faker::create('id_ID');
        $today = Carbon::today('GMT+7');

        $random_type = ['Free', 'Berbayar', 'Barter'];
        $gender = $this->faker->randomElement(['male', 'female']);
        $random_nspk = mt_rand(100, 999) . '/SPK/IX/TVKU/' . $this->faker->year();
        $random_priority = ['Biasa', 'Penting', 'Sangat Penting'];

        return [
            'user_id' => mt_rand(2, 3),
            'type' => $random_type[array_rand($random_type)],
            'client' => 'PT. ' . $this->faker->name($gender),
            'nspp' => $this->faker->numerify(),
            'nspk' => $random_nspk,
            'description' => $faker->sentence(mt_rand(3, 6)),
            'deadline' => $this->faker->date('d_m-Y'),
            'info' => $faker->sentence(mt_rand(3, 5)) . '<BR>' . $faker->sentence(mt_rand(3, 5)) . '<BR>' . $faker->sentence(mt_rand(3, 5)) . '<BR>',
            'priority' => NULL,
            'created' => $today,
            'approval' => NULL,
            'approval_date' =>  NULL,
            'submit' => FALSE,
            'unique_id' => Str::random(32),
        ];
    }
}
