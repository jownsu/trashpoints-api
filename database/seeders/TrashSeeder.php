<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TrashSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        if(!DB::table('trashes')->count()){
            DB::unprepared(file_get_contents(__DIR__ . '/sql/Trashes.sql'));
        }
    }
}
