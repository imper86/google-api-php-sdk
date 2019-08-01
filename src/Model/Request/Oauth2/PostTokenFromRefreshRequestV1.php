<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 01.08.2019
 * Time: 11:12
 */

namespace Imper86\GoogleApiPhpSdk\Model\Request\Oauth2;


use GuzzleHttp\Psr7\Request;
use Imper86\GoogleApiPhpSdk\Constants\EndpointUri;
use Imper86\GoogleApiPhpSdk\Model\Credentials\AppCredentialsInterface;
use Imper86\GoogleApiPhpSdk\Model\Request\RequestTrait;

class PostTokenFromRefreshRequestV1 extends Request
{
    use RequestTrait;

    public function __construct(AppCredentialsInterface $credentials, string $refreshToken)
    {
        parent::__construct(
            'POST',
            EndpointUri::API . '/oauth2/v4/token',
            ['Content-Type' => 'application/x-www-form-urlencoded'],
            http_build_query([
                'refresh_token' => $refreshToken,
                'client_id' => $credentials->getClientId(),
                'client_secret' => $credentials->getClientSecret(),
                'grant_type' => 'refresh_token',
            ])
        );
    }
}
