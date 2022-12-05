<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$date = Carbon::now();

		$categories = [
			[
				'name' => 'Категория 1',
				'parent_id' => 0,
				'created_at' => $date,
				'updated_at' => $date,
			],
			[
				'name' => 'Категория 2',
				'parent_id' => 0,
				'created_at' => $date,
				'updated_at' => $date,
			],
			[
				'name' => 'Категория 3',
				'parent_id' => 0,
				'created_at' => $date,
				'updated_at' => $date,
			],
		];

		for ($i = 4; $i <= 12; $i++) {
			$name = 'Категория ' . $i;

			$categories[] = [
				'parent_id' => mt_rand(1, 3),
				'name' => $name,
				'created_at' => $date,
				'updated_at' => $date,
			];
		}

		DB::table('categories')->insert($categories);
    }
}
