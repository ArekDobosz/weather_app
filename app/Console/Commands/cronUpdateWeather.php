<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Helpers\WeatherHelper;
use App\Jobs\CheckPreferences;
use Carbon\Carbon;

class cronUpdateWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update weather parameters';

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
        WeatherHelper::update();

        $job = (new CheckPreferences())
            ->delay(Carbon::now()->addSeconds(10));

        dispatch($job);
    }
}
