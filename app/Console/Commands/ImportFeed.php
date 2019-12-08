<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\Feed as FeedHelper;
use App\Models\Feed as FeedModel;

class ImportFeed extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'import-feed {feed? : Feed id or url (optional: leave blank to update all feeds)}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Imports specific currency feed or all feeds';

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
    public function handle(FeedHelper $feedhelper)
    {
		$input = $this->argument('feed');
		$feeds = [];

		if ($input) {
			if (!$feedhelper->validate($input)) {
				$this->error("Whoops... that's not a known feed. Please provide a known feed (either id or url).");
				return;
			}
		}

		$this->line('Processing...');
		if ($feedhelper->import()) {
			$this->info("All feeds processed.");
		} else {
			$this->error("Whoops... that didn't work. Reason: " . $feedhelper->error);
		}
    }
}
