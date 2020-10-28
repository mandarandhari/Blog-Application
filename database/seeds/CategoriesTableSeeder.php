<?php

use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'category_name' => 'Travel',
            'color_code' => '#f57242'
        ]);

        DB::table('categories')->insert([
            'category_name' => 'Food',
            'color_code' => '#f54282'
        ]);

        DB::table('categories')->insert([
            'category_name' => 'Gadgets',
            'color_code' => '#426ff5'
        ]);

        DB::table('categories')->insert([
            'category_name' => 'Beauty',
            'color_code' => '#2b8a2b'
        ]);
    }
}
