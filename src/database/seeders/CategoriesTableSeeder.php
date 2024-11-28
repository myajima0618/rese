<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
            'category_name' => '寿司',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('categories')->insert($param);

        $param = [
            'category_name' => '焼肉',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('categories')->insert($param);

        $param = [
            'category_name' => '居酒屋',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('categories')->insert($param);

        $param = [
            'category_name' => 'イタリアン',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('categories')->insert($param);

        $param = [
            'category_name' => 'ラーメン',
            'created_at' => now(),
            'updated_at' => now()
        ];
        DB::table('categories')->insert($param);
    }
}
