<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 17:51
 */

namespace Imper86\GoogleApiPhpSdk;

use DateTime;
use Http\Adapter\Guzzle6\Client as GuzzleAdapter;
use Imper86\GoogleApiPhpSdk\Constants\EndpointUri;
use Imper86\GoogleApiPhpSdk\Exception\BadResponseException;
use Imper86\GoogleApiPhpSdk\Factory\LogFactory;
use Imper86\GoogleApiPhpSdk\Model\Credentials\AppCredentialsInterface;
use Imper86\GoogleApiPhpSdk\Model\Request\Oauth2\GetRevokeRequestV1;
use Imper86\GoogleApiPhpSdk\Model\Request\Oauth2\PostTokenFromCodeRequestV1;
use Imper86\GoogleApiPhpSdk\Model\Request\Oauth2\PostTokenFromRefreshRequestV1;
use Imper86\GoogleApiPhpSdk\Model\TokenBundle\TokenBundle;
use Imper86\GoogleApiPhpSdk\Model\TokenBundle\TokenBundleInterface;
use Psr\Http\Client\ClientInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class AuthService implements AuthServiceInterface
{
    /**
     * @var ClientInterface
     */
    private $httpClient;
    /**
     * @var LoggerInterface|null
     */
    private $logger;

    public function __construct(?ClientInterface $httpClient = null, ?LoggerInterface $logger = null)
    {
        $this->httpClient = $httpClient ?? GuzzleAdapter::createWithConfig([]);
        $this->logger = $logger;
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

    public function fetchTokenFromCode(
        AppCredentialsInterface $credentials,
        string $code,
        array $logContext = []
    ): TokenBundleInterface
    {
        $request = new PostTokenFromCodeRequestV1($credentials, $code);

        try {
            $response = $this->httpClient->sendRequest($request);

            if ($response->getStatusCode() > 299) {
                throw new BadResponseException($request, $response);
            }

            LogFactory::log($this->logger, $logContext, $request, $response, null);

            $bundle = new TokenBundle((string)$response->getBody());
            $bundle->setCreatedAt(new DateTime());

            return $bundle;
        } catch (Throwable $exception) {
            LogFactory::log($this->logger, $logContext, $request, null, $exception);

            throw $exception;
        }
    }

    public function fetchTokenFromRefresh(
        AppCredentialsInterface $credentials,
        string $refreshToken,
        array $logContext = []
    ): TokenBundleInterface
    {
        $request = new PostTokenFromRefreshRequestV1($credentials, $refreshToken);

        try {
            $response = $this->httpClient->sendRequest($request);

            if ($response->getStatusCode() > 299) {
                throw new BadResponseException($request, $response);
            }

            LogFactory::log($this->logger, $logContext, $request, $response, null);

            $bundle = new TokenBundle((string)$response->getBody());
            $bundle->setCreatedAt(new DateTime());

            if (empty($bundle->getRefreshToken())) {
                $bundle->setRefreshToken($refreshToken);
            }

            return $bundle;
        } catch (Throwable $exception) {
            LogFactory::log($this->logger, $logContext, $request, null, $exception);

            throw $exception;
        }
    }

    public function revokeToken(string $token, array $logContext = []): void
    {
        $request = new GetRevokeRequestV1($token);

        try {
            $response = $this->httpClient->sendRequest($request);

            if ($response->getStatusCode() > 299) {
                throw new BadResponseException($request, $response);
            }

            LogFactory::log($this->logger, $logContext, $request, $response, null);
        } catch (Throwable $exception) {
            LogFactory::log($this->logger, $logContext, $request, null, $exception);

            throw $exception;
        }
    }
}
