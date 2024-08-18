<?php

namespace Brunocfalcao\Tracer;

use Brunocfalcao\Cerebrus\ConcernsSessionPersistence;
use Brunocfalcao\Tracer\Models\Visit;
use Illuminate\Support\Facades\Route;
use Jaybizzle\CrawlerDetect\CrawlerDetect;
use Jenssegers\Agent\Facades\Agent;

class Tracer
{
    use ConcernsSessionPersistence;

    public function __construct()
    {
        $this->withPrefix('tracer:visit');
    }

    public static function make(...$args)
    {
        return new self(...$args);
    }

    /**
     * Creates a new tracer visit instance, saves it into the database and
     * places the instance in session for further use. At the moment
     * we don't evaluate the session data, we just overwrite
     * it each time we record a new visit instance.
     *
     * @return Models\Visit
     */
    public function record()
    {
        $instance = $this->newInstance();

        $this->overwrite(function () use ($instance) {
            return $instance;
        });
    }

    public function get()
    {
        return $this->session();
    }

    /**
     * Computes a new visit instance, saves in session, and returns the
     * model instance.
     *
     * @return Visit
     */
    protected function newInstance()
    {
        $visit = new Visit;
        $visit->session_id = $this->sessionId();
        $visit->url = request()->fullUrl();
        $visit->path = request()->path();
        $visit->route_name = Route::currentRouteName();

        // Create an unique hashcode. GDPA related.
        $visit->hash = md5(request()->ip().
            Agent::platform().
            Agent::device());

        // Verify if the request is a bot request.
        $crawlerDetect = new CrawlerDetect;

        // Check the user agent of the current visit source.
        $visit->is_bot = $crawlerDetect->isCrawler();

        // Check the campaign, an referrer data.
        $referrer = app('tracer-referrer')->get();

        $visit->referrer_utm_source = $referrer->utm_source;
        $visit->referrer_domain = $referrer->domain;

        $visit->save();

        return $visit;
    }

    /**
     * Returns the public ip address from a visit. In case it's a localhost
     * ip address, it called the rest API from ipinfo.io to try to translate
     * into a public ip address.
     *
     * @return string
     */
    protected function ip()
    {
        try {
            return request()->ip() == '127.0.0.1' ?
                file_get_contents('https://ipinfo.io/ip') :
                request()->ip();
        } catch (\Exception $ex) {
            return request()->ip();
        }
    }
}
