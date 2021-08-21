<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StoreTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('mst_store_types')->insert(
            array(
                array("name" => "Sport" , "created_at" => \Carbon\Carbon::now() , "updated_at" => \Carbon\Carbon::now()),
                array("name" => "Food & Breckfast" , "created_at" => \Carbon\Carbon::now() , "updated_at" => \Carbon\Carbon::now()),
                array("name" => "Fashion" , "created_at" => \Carbon\Carbon::now() , "updated_at" => \Carbon\Carbon::now()),
            )
        );
    }
}
