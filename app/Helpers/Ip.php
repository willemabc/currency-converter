<?php

namespace App\Helpers;

use App\Models\Ip as IpModel;
use IPLib\Factory as IPLibFactory;
use Log;

class Ip
{
	public $error;
	protected $range;

	/*
		@todo: should not allow single ip address to be added if a matching range already exists or vice versa
	*/
	public function validate($input)
	{
		$range = IPLibFactory::rangeFromString($input);

		// first basic check: we only support IP address (192.168.0.1) and IP range (192.168.0.*), not CIDR stuff
		// second check: is this a valid ip or range?
		if (!preg_match("/[0-9\.\*]+/i", $input) || !$range) {
			$this->error = "IP address or IP range does not validate";

			Log::info('IP range could not be added: ' . $input);
			return false;
		}

		// check to see if ip range is already known
		$ip = IpModel::where(['from' => $range->getStartAddress(), 'to' => $range->getEndAddress()])->first();
		if ($ip) {
			$this->error = "IP address or IP range has already been added";
			return false;
		}

		$this->range = $range;
		return true;
	}

	public function add()
	{
		if (!$this->range) {
			return false;
		}

		// add new ip range
		$ip = IpModel::create([
			'from' => $this->range->getStartAddress(),
			'to' => $this->range->getEndAddress()
		]);

		Log::info('IP range added: ' . $ip->from . ' - ' . $ip->to);

		return true;
	}
}
