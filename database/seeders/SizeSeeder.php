<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class SizeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('sizes')->insertOrIgnore([
            ['name' => 'Default'],
            ['name' => 'Small'],
            ['name' => 'Medium'],
            ['name' => 'Large']
        ]);
    }
}
