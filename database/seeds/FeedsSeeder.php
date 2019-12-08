<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;
use App\Models\Feed;

class FeedsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		// @todo scrape the available feeds with fallback on pre-stored json
		$feeds = json_decode(File::get(resource_path('feeds.json')), true);
		foreach($feeds as $feed) {
			$feed = Feed::create([
				'name' => $feed['name'],
				'url' => $feed['url']
			]);
		}
    }
}
