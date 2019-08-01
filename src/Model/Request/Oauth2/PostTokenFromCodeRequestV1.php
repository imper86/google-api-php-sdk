<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 01.08.2019
 * Time: 11:10
 */

namespace Imper86\GoogleApiPhpSdk\Model\Request\Oauth2;


use GuzzleHttp\Psr7\Request;
use Imper86\GoogleApiPhpSdk\Constants\EndpointUri;
use Imper86\GoogleApiPhpSdk\Model\Credentials\AppCredentialsInterface;
use Imper86\GoogleApiPhpSdk\Model\Request\RequestTrait;

class PostTokenFromCodeRequestV1 extends Request
{
    use RequestTrait;

    public function __construct(AppCredentialsInterface $credentials, string $code)
    {
        parent::__construct(
            'POST',
            EndpointUri::API . '/oauth2/v4/token',
            ['Content-Type' => 'application/x-www-form-urlencoded'],
            http_build_query([
                'code' => $code,
                'client_id' => $credentials->getClientId(),
                'client_secret' => $credentials->getClientSecret(),
                'redirect_uri' => $credentials->getRedirectUri(),
                'grant_type' => 'authorization_code',
            ])
        );
    }
}
