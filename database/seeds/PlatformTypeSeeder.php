<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PlatformTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_platform_types')->insert(
            array(
                array("name" => "Instagram" , "created_at" => \Carbon\Carbon::now() , "updated_at" => \Carbon\Carbon::now()),
                array("name" => "Facebook" , "created_at" => \Carbon\Carbon::now() , "updated_at" => \Carbon\Carbon::now()),
                array("name" => "Yotube" , "created_at" => \Carbon\Carbon::now() , "updated_at" => \Carbon\Carbon::now()),
                array("name" => "Tiktok" , "created_at" => \Carbon\Carbon::now() , "updated_at" => \Carbon\Carbon::now()),
                array("name" => "Twitter" , "created_at" => \Carbon\Carbon::now() , "updated_at" => \Carbon\Carbon::now()),
            )
        );
    }
}
