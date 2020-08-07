<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class userSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();


        $faker = Faker::create();
        for ($i=1; $i<=5; $i++)
        {
            DB::table('users')->insert([
                "name" => $faker->name ,
                "email" =>$faker->email ,
                "password" =>bcrypt('123456') ,
                "join_date" =>$faker->date('Y-m-d','now') ,
                "job_status"=>"1",
                 "user_image" =>"user.jpg" ,
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ]);
        }
        for ($i=1; $i<=5; $i++)
        {
            DB::table('users')->insert([
                "name" => $faker->name ,
                "email" =>$faker->safeEmail ,
                "password" =>bcrypt('123456') ,
                "join_date" =>$faker->date('Y-m-d','now') ,
                "leave_date" =>$faker->date('Y-m-d','now') ,
                "job_status"=>"0",
                "user_image" =>"user.jpg" ,
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ]);
        }
        for ($i=1; $i<=15; $i++)
        {
            DB::table('users')->insert([
                "name" => $faker->name ,
                "email" =>$faker->freeEmail ,
                "password" =>bcrypt('123456') ,
                "join_date" =>$faker->date('Y-m-d','now') ,
                "job_status"=>"1",
                "user_image" =>"user.jpg" ,
                'created_at'=>date('Y-m-d h:i:s'),
                'updated_at'=>date('Y-m-d h:i:s')
            ]);
        }
    }
}
