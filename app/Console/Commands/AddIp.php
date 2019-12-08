<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Ip as IpHelper;

class AddIp extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'add-ip {ip : IP address (192.168.0.1) or IP range (192.168.0.*)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Adds IP address or range for user access';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle(IpHelper $iphelper)
    {
		$input = $this->argument('ip');

		$this->line("Adding IP address or IP range: " . $input);


		if ($iphelper->validate($input)) {
			$iphelper->add();
			$this->info("Success.");
		} else {
			$this->error("Whoops... that didn't work. Reason: " . $iphelper->error);
		}
    }
}
