<?php

return [

    /**
     * The queue name where the jobs should run.
     */
    'queue' => env('LARAVEL_TRACER_QUEUE_NAME', 'default'),

    /*
     * By default, the user model is connected to your default user providers
     * authenticaton model class. You can change to your own users class or
     * keep it like it is.
     *
     * E.g.: \App\Models\User::class
     */
    'user' => config('auth.providers.users.model'),

    /*
     * What DNS servers should be used to check if an ip is blacklisted. The
     * more servers you have, the higher is the chance of false positive ips.
     */
    'dns' => [
        'blacklist_servers' => [
            'dnsbl-1.uceprotect.net',
            'dnsbl-2.uceprotect.net',
            'dnsbl-3.uceprotect.net',
            'dnsbl.dronebl.org',
            'dnsbl.sorbs.net',
            'zen.spamhaus.org',
            'bl.spamcop.net',
            'list.dsbl.org',
        ],
    ],

    'goals' => [

        //Brunocfalcao\Tracer\Goals\NthVisit::class,

        /*
         * 1st-time: A visitor that visited, once, the website
         * nth-times: A visitor that visited, more than once, the website.
         * purchase-click: A visitor that clicked on the purchase.
         * purchased-completed: A visitor that completed the purchase.
         * purchase-abandoned: A visitor that abandoned the purchase.
         * from-promotion: A visitor that refered from a promotional campaign.
         * from-referal: A visitor that refered from another named referal.
         * refunded: A visitor that requested a refund.
         */

    ],

    'url' => [

        // url paths that we don't want to trace at all.
        'exceptions' => [

        ],
    ],
];
