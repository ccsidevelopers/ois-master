<?php

namespace App\Http\Middleware;

use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier
{
    /**
     * The URIs that should be excluded from CSRF verification.
     *
     * @var array
     */
    protected $except = [

        // 'http://ois.localhost/api/endorse/pdrn',
        // 'http://ois.localhost/api/endorse/evr',
        // 'http://ois.localhost/api/endorse/bvr',
        // 'http://ois.localhost/api/endorse/coborrower',
        // 'http://ois.localhost/api/download_account_link',
        // 'http://ois.localhost/api/fetch/tele/endorsements',
        // 'http://ois.localhost/api/enodrse/tele/pdrn',
        // 'http://ois.localhost/api/enodrse/tele/evr',
        // 'http://ois.localhost/api/enodrse/tele/bvr',
        // 'http://ois.localhost/api/fetch/cc/package_check',
        // 'http://ois.localhost/api/fetch/cc/endorsements',
        // 'http://ois.localhost/api/endorse/cc/accounts',
        // 'http://ois.localhost/api/download_attachment_link',
        // 'http://ois.localhost/download_success_attachment_link',
        // 'http://ois.localhost/cc-tele-html-to-pdf',

        'https://www.ccsi-oims.net/api/endorse/pdrn',
        'https://www.ccsi-oims.net/api/endorse/evr',
        'https://www.ccsi-oims.net/api/endorse/bvr',
        'https://www.ccsi-oims.net/api/endorse/coborrower',
        'https://www.ccsi-oims.net/api/download_account_link',
        'https://www.ccsi-oims.net/api/fetch/tele/endorsements',
        'https://www.ccsi-oims.net/api/enodrse/tele/pdrn',
        'https://www.ccsi-oims.net/api/enodrse/tele/evr',
        'https://www.ccsi-oims.net/api/enodrse/tele/bvr',
        'https://www.ccsi-oims.net/api/fetch/cc/package_check',
        'https://www.ccsi-oims.net/api/fetch/cc/endorsements',
        'https://www.ccsi-oims.net/api/endorse/cc/accounts',
        'https://www.ccsi-oims.net/api/download_attachment_link',
        'https://www.ccsi-oims.net/download_success_attachment_link',
        'https://www.ccsi-oims.net/cc-tele-html-to-pdf',

        'https://maps.googleapis.com/maps/api/geocode/json'

    ];
}
