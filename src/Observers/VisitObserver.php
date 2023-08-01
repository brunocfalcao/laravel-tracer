<?php

namespace Brunocfalcao\Tracer\Observers;

use Brunocfalcao\Tracer\Jobs\GetVisitGeoDataJob;
use Brunocfalcao\Tracer\Models\Visit;
use Jenssegers\Agent\Facades\Agent;

class VisitObserver
{
    public function saving(Visit $visit)
    {
        // Hashing visit information for GDPR reasons.
        $visit->hash = md5(
            request()->ip2().
            Agent::platform().
            Agent::device()
        );
    }

    public function created(Visit $visit)
    {
        GetVisitGeoDataJob::dispatch($visit->id, request()->ip2());
    }
}
