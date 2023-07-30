<?php

namespace Brunocfalcao\Tracer\Commands;

use Brunocfalcao\Tracer\Middleware\JobRateLimited;
use Brunocfalcao\Tracer\Models\Visit;
use Illuminate\Console\Command;

class GetGeoDataCommand extends Command
{
    protected $signature = 'tracer:get-geo-data';

    protected $description = 'Queues and fetches all the pending visit nullable geo data';

    public function __construct()
    {
        parent::__construct();
    }

    public function handle()
    {
        $pendingVisits = Visit::whereNull('country')->get();

        $pendingVisits->each(function ($visit) {
            GetVisitGeoData::dispatch($visit->id)->release(5);
        });

        return 0;
    }

    public function middleware(): array
    {
        return [new JobRateLimited(1, 5)]; // 1 job each 5 seconds.
    }
}
