<?php

namespace Database\Seeders;

use App\Models\People;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PeopleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        foreach (range(1, 10) as $index) {

            $gender = $faker->randomElement(['male', 'female']);

            People::create([
                'name' => $faker->name(),
                'age' => $faker->numberBetween(18,100),
                'gender' => $gender,
                'created_at' => $faker->dateTimeBetween('-1 year', 'now'),
                'updated_at' => $faker->dateTimeBetween('-1 year', 'now'),
            ]);
        }
    }
}
