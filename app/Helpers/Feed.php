<?php

namespace App\Helpers;

use App\Models\Currency as CurrencyModel;
use App\Models\Feed as FeedModel;
use App\Models\Rate as RateModel;
use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\ClientException as GuzzleClientException;
use Carbon\Carbon;
use Log;

class Feed
{
	public $error;
	protected $feeds = [];

	public function validate($input)
	{
		if (is_numeric($input)) {
			$feed = FeedModel::where('id', $input)->first();
		} else {
			$feed = FeedModel::where('url', $input)->first();
		}

		if (!$feed) {
			$this->error = "Unknown feed.";

			Log::info('Updating feed failed: ' . $input);
			return false;
		}

		$this->feeds[] = $feed;
		return true;

	}

	public function import()
	{
		if (!$this->feeds) {
			$this->feeds = FeedModel::all();
		}

		$guzzle = new GuzzleClient();
		foreach($this->feeds as $feed) {
			// determine from currency from url (admittedly, this is a bit dirty @todo)
			$currencyFrom = CurrencyModel::where('code', strtoupper(substr($feed->url, -8, 3)))->first();

			try {
				$request = $guzzle->get($feed->url);
		        if ($request->getStatusCode() == 200) {
					// grab & save currency rates from data rows
					$data = json_decode((string)$request->getBody(), true);
					foreach ($data as $dataRow) {
						$currencyTo = CurrencyModel::where('code', $dataRow['code'])->first();

						$rate = RateModel::firstOrNew(['currency_id_from' => $currencyFrom->id, 'currency_id_to' => $currencyTo->id]);
						$rate->rate = $dataRow['rate'];
						$rate->refreshed_at = Carbon::parse($dataRow['date']);
						$rate->save();
					}
		        }

	        } catch (GuzzleClientException $e) {
				// we keep going with other feeds: for this failed feed we'll just try again in the next cronjob round
				$this->error = "Unable to fetch feed " . $feed->id . ".";
				Log::info('Feed could not be fetched: ' . $feed->id);
	        }
		}

		return true;
	}
}
