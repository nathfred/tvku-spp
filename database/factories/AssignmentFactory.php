<?php

namespace Database\Factories;

use App\Models\Assignment;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;
use Faker\Factory as Faker;

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

        $gender = $this->faker->randomElement(['male', 'female']);
        $random_nspk = mt_rand(100, 999) . '/SPK/IX/TVKU/' . $this->faker->year();
        $random_priority = ['Biasa', 'Penting', 'Sangat Penting'];

        return [
            'user_id' => mt_rand(2, 3),
            'client' => 'PT. ' . $this->faker->name($gender),
            'nspp' => $this->faker->numerify(),
            'nspk' => $random_nspk,
            'description' => $faker->sentence(mt_rand(3, 6)),
            'deadline' => $this->faker->dateTime(),
            'info' => $faker->sentence(mt_rand(3, 5)) . '<BR>' . $faker->sentence(mt_rand(3, 5)) . '<BR>' . $faker->sentence(mt_rand(3, 5)) . '<BR>',
            'info' => 'haha',
            'priority' => $random_priority[array_rand($random_priority)],
            'created' => $today,
            'approval' => NULL,
            'approval_date' =>  NULL,
            'status' => FALSE
        ];
    }
}
