<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 01.08.2019
 * Time: 11:14
 */

namespace Imper86\GoogleApiPhpSdk\Model\Request\Oauth2;


use GuzzleHttp\Psr7\Request;
use Imper86\GoogleApiPhpSdk\Constants\EndpointUri;
use Imper86\GoogleApiPhpSdk\Model\Request\RequestTrait;

class GetRevokeRequestV1 extends Request
{
    use RequestTrait;

    public function __construct(string $token)
    {
        parent::__construct(
            'GET',
            EndpointUri::AUTH .  '/o/oauth2/revoke?' . http_build_query(['token' => $token]),
            ['Content-Type' => 'application/x-www-form-urlencoded']
        );
    }
}
