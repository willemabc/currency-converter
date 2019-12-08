<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rate;

class ApiController extends Controller
{
    public function rates(Request $request)
    {
		if (!$request->currency) return false;

		$rates = Rate::with('currencyTo')->where('currency_id_from', $request->currency)->get();
		$data = [];

		foreach ($rates as $rate) {
			$data[$rate->currencyTo->code] = [
				'name' => $rate->currencyTo->name,
				'code' => $rate->currencyTo->code,
				'rate'=> $rate->rate
			];
			ksort($data);
		}

		return response()->json($data);
    }
}
