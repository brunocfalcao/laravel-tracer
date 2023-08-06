<?php

namespace Brunocfalcao\Tracer\Jobs;

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
class GetVisitGeoDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $visitId;
    public $ip;

    public function __construct(int $visitId, string $ip)
    {
        $this->visitId = $visitId;
        $this->ip = $ip;

        $this->onQueue(config('tracer.queue'));
    }

    public function handle()
    {
        $visit = Visit::find($this->visitId);

        if ($visit) {
        // Make the API call with a specific number of fields.
            try {
                $response = Http::get('http://ip-api.com/json/' .
                                $this->ip .
                                '?fields=12108287')
                        ->json();

                if ($response['status'] == 'success') {
                    $visit->updateGeoData($response);
                };
            } catch (\Exception $ex) {
                $this->release(60);
            }
        }
    }
}
