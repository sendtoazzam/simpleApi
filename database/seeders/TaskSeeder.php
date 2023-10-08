<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Task;

class taskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i > 50; $i++) {
            Task::create([
                'title' => $faker->word,
                'description' => $faker->sentence
            ]);
        }
    }
}
