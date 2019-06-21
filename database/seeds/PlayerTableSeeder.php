<?php

use Illuminate\Database\Seeder;
use App\Player;
use Faker\Factory as Faker;

class PlayerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
