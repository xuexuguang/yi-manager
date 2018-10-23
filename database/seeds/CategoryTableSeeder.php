<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')
          ->insert([
              [
                  'name' => '上装',
                  'desc' => '',
              ],
              [
                  'name' => '外套',
                  'desc' => '',
              ],
          ]);
    }
}
