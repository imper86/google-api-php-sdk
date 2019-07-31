<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 17:51
 */

namespace Imper86\GoogleApiPhpSdk;

use GuzzleHttp\Psr7\Request;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Imper86\GoogleApiPhpSdk\Constants\EndpointUri;
use Imper86\GoogleApiPhpSdk\Model\Credentials\AppCredentialsInterface;
use Imper86\GoogleApiPhpSdk\Model\TokenBundle\TokenBundle;
use Imper86\GoogleApiPhpSdk\Model\TokenBundle\TokenBundleInterface;
use Psr\Http\Client\ClientInterface;

class AuthService implements AuthServiceInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;

    public function __construct(?ClientInterface $httpClient = null)
    {
        $this->httpClient = $httpClient ?? GuzzleAdapter::createWithConfig([]);
    }

    public function createAuthUrl(
        AppCredentialsInterface $credentials,
        array $scopes = [],
        string $accessType = 'offline',
        array $additionalParameters = []
    ): string
    {
        $additionalParameters['client_id'] = $credentials->getClientId();
        $additionalParameters['redirect_uri'] = $credentials->getRedirectUri();
        $additionalParameters['scope'] = implode(' ', $scopes);
        $additionalParameters['access_type'] = $accessType;
        $additionalParameters['response_type'] = 'code';

        return EndpointUri::AUTH . '/o/oauth2/v2/auth?' . http_build_query($additionalParameters);
    }

    public function fetchTokenFromCode(AppCredentialsInterface $credentials, string $code): TokenBundleInterface
    {
        $request = new Request(
            'POST',
            EndpointUri::API . '/oauth2/v4/token',
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            http_build_query([
                'code' => $code,
                'client_id' => $credentials->getClientId(),
                'client_secret' => $credentials->getClientSecret(),
                'redirect_uri' => $credentials->getRedirectUri(),
                'grant_type' => 'authorization_code',
            ])
        );

        $response = $this->httpClient->sendRequest($request);

        return new TokenBundle((string)$response->getBody());
    }

    public function fetchTokenFromRefresh(AppCredentialsInterface $credentials, string $refreshToken): TokenBundleInterface
    {
        $request = new Request(
            'POST',
            EndpointUri::API . '/oauth2/v4/token',
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ],
            http_build_query([
                'refresh_token' => $refreshToken,
                'client_id' => $credentials->getClientId(),
                'client_secret' => $credentials->getClientSecret(),
                'grant_type' => 'refresh_token',
            ])
        );

        $response = $this->httpClient->sendRequest($request);

        return new TokenBundle((string)$response->getBody());
    }

    public function revokeToken(string $token): void
    {
        $request = new Request(
            'GET',
            EndpointUri::AUTH . '/o/oauth2/revoke?' . http_build_query(['token' => $token]),
            [
                'Content-Type' => 'application/x-www-form-urlencoded',
            ]
        );

        $this->httpClient->sendRequest($request);
    }
}
