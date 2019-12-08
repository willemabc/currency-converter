<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Currency;

class CurrenciesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// @todo scrape the available feeds with fallback on pre-stored json
		$currencies = json_decode(File::get(resource_path('currencies.json')), true);
		foreach($currencies as $currency) {
			$currency = Currency::create([
				'name' => $currency['name'],
				'code' => $currency['code']
			]);
		}
    }
}
