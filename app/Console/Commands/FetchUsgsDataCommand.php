<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Events\FetchUsgsDataEvent;

class FetchUsgsDataCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'meq2016:fetch-usgs-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch database from USGS';

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
    public function handle()
    {
        $event = new FetchUsgsDataEvent();
        event($event);
        dd($event);
    }
}
