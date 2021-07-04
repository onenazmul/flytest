<?php

use Illuminate\Database\Seeder;

class ParceltypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('parceltypes')->insert([
            'title'=>'pending',
            'slug'=>'pending'
        ]);
        DB::table('parceltypes')->insert([
            'title'=>'picked',
            'slug'=>'picked'
        ]);
        DB::table('parceltypes')->insert([
            'title'=>'In Transit',
            'slug'=>'in-transit'
        ]);
        DB::table('parceltypes')->insert([
            'title'=>'Deliverd',
            'slug'=>'deliverd'
        ]);
        DB::table('parceltypes')->insert([
            'title'=>'Hold',
            'slug'=>'hold'
        ]);
        DB::table('parceltypes')->insert([
            'title'=>'Return Pending',
            'slug'=>'return-pending'
        ]);
        DB::table('parceltypes')->insert([
            'title'=>'Return To Hub',
            'slug'=>'return-to-hub'
        ]);
        DB::table('parceltypes')->insert([
            'title'=>'Return To Merchant',
            'slug'=>'return-to-merchant'
        ]);
        DB::table('parceltypes')->insert([
            'title'=>'Cancelled',
            'slug'=>'cancelled'
        ]);
    }
}
