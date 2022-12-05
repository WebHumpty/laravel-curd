<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$date = Carbon::now();
        $products = [];

        for ($i = 1; $i <= 15; $i++) {
        	$products[] = [
        		'category_id' => mt_rand(4, 12),
				'name' => "Товар {$i}",
				'price' => mt_rand(50, 1000),
				'created_at' => $date,
				'updated_at' => $date,
			];
		}

        DB::table('products')->insert($products);
    }
}
