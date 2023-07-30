<?php

namespace Brunocfalcao\Tracer;

use Brunocfalcao\Cerebrus\ConcernsSessionPersistence;

/**
 * Analyses if there is a referrer that should be taken in context for the
 * current user session. The referrer information can be used for visits
 * analytics, or to connect the referrer utm_source/domain to an
 * affiliate model.
 *
 * REMARK:
 * We cannot connect a referrer to an affiliate WITHOUT having a product id
 * to contextualize the affiliate. Because affiliates are not part
 * of all the products that will exist in the LMS for all the courses.
 */
class Referrer
{
    use ConcernsSessionPersistence;

    /**
     * This is not an affiliate model, but a stdClass with 2 properties:
     * ->source (if it's 'utm_source' or 'domain', db columns from affiliates)
     * ->value (the value of the referrer value for the respective case).
     *
     * E.g.: Referrer with http header "referer" = 'laravel.com':
     * ->source = 'domain'
     * ->value = 'laravel.com'
     *
     * E.g.: Referrer with utm_source "?utm_source=laravelnews"
     * ->source = 'utm_source'
     * ->value = 'laravelnews'
     *
     * The utm_source querystring has higher priority than the http header.
     *
     * @var stdClass
     */
    private $referrer = null;

    public function __construct()
    {
        $this->withPrefix('tracer:referrer')
             ->persist(function () {
                 return $this->newInstance();
             });
    }

    public static function make(...$args): self
    {
        return new self(...$args);
    }

    /**
     * Returns an stdClass with 2 properties (source and value) for the
     * referrer, in case it exists.
     *
     * @return stdClass|null
     */
    public function get()
    {
        return $this->session();
    }

    /**
     * An stdClass with 2 properties:
     * ->source (if it's 'utm_source' or 'domain', db columns from affiliates)
     * ->value (the value of the referrer value for the respective case).
     *
     * E.g.: Referrer with http header "referer" = 'laravel.com':
     * ->source = 'domain'
     * ->value = 'laravel.com'
     *
     * E.g.: Referrer with utm_source "?utm_source=laravelnews"
     * ->source = 'utm_source'
     * ->value = 'laravelnews'
     *
     * The utm_source querystring has higher priority than the http header.
     *
     * @var stdClass
     */
    public function newInstance()
    {
        $result = new \stdClass();

        $result->utm_source = null;
        $result->domain = null;

        $result->utm_source = request()->input('utm_source');
        $result->domain = request()->headers->get('referer');

        return $result;
    }
}
