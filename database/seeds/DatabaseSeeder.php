<?php

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(PlayerTableSeeder::class);
        $faker = Faker::create();
    	foreach (range(1,10) as $index) {
	        DB::table('players')->insert([
	            'name' => $faker->name,
                'answers' => $faker->numberBetween($min = 0, $max = 100),
                'points' => $faker->numberBetween($min = 0, $max = 100),
	        ]);
        }
    }
}
