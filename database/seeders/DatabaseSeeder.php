<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        DB::table('roles')->insert([
            'name' => 'admin'
        ]);
        DB::table('roles')->insert([
            'name' => 'user'
        ]);
      
        for($i = 1; $i <=7; $i++) {
            DB::table('users')->insert([
                'email'=>$faker->email,
                'password'=>$faker->password,
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'phone' => $faker->e164PhoneNumber,
                'birth_date' => $faker->dateTime,
                'role_id'=> rand(1,2)
            ]); 
        }
        for($i = 1; $i <=7; $i++) {
            DB::table('insurances')->insert([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'phone' => $faker->e164PhoneNumber,
                'type' => rand(0,1),
                'start_date' => $faker->dateTimeBetween('-10 years','-1 years'),
                'end_date' => $faker->dateTimeBetween('-1 years','now'),
                'user_id'=> rand(1,7)
            ]); 
        }
        for($i = 1; $i <=7; $i++) {
            DB::table('news')->insert([
                'user_id' => rand(1,7),
                'title' => $faker->word,
                'desc' => $faker->text,
                'text' => $faker->text,
                'cover' => 'img'.$i.'.jpg' ,
                'alt' => 'img'.$i,
                'news_type'=>rand(0,1),
                'status'=> 'in process',
                'created_at'=> $faker->dateTimeBetween('-2 months','-1 months'),
            ]); 
        }
        for($i = 1; $i <=7; $i++) {
            DB::table('persons')->insert([
                'name' => $faker->firstName,
                'surname' => $faker->lastName,
                'birth_date' => $faker->dateTimeBetween('-10 years','-1 years'),
                'insurance_id'=> rand(1,7)
            ]); 
        }
    }
}
