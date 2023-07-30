<?php

namespace QRFeedz\Tracer\Jobs;

use Brunocfalcao\Tracer\Models\Visit;
use Brunocfalcao\Logger\Facades\ApplicationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\Middleware\WithoutOverlapping;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

/**
 * This job runs on a scheduled cron job, via a command called
 * tracer:get-geo-data that will fetch all the lines that have
 * nullable geo data, and tries to update that data.
 */
class GetVisitGeoData implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $visitId;

    public function __construct(int $visitId)
    {
        $this->visitId = $visitId;

        $this->onQueue(config('tracer.queue', 'default'));
    }

    public function handle()
    {
        $visit = Visit::find($visitId);

        // Make the API call with a specific number of fields.
        $response = Http::get('http://ip-api.com/json/' .
                            $this->visit->ip.'?fields=12108287')
                        ->json();

        if ($response['status'] == 'success') {
            Visit::where('hash', $this->hash)
                 ->get()
                 ->each
                 ->updateGeoData($response);
        } else {
            ApplicationLog::properties($response)
                          ->group('error-system')
                          ->log('Visit geocode error');
        }
    }

    public function middleware()
    {
        return [new WithoutOverlapping($this->visitId)];
    }
}
