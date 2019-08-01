<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 18:30
 */

namespace Imper86\GoogleApiPhpSdk;


use Http\Adapter\Guzzle6\Client;
use Imper86\GoogleApiPhpSdk\Factory\LogFactory;
use Psr\Http\Client\ClientInterface;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class ApiService implements ApiServiceInterface
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
        $this->httpClient = $httpClient ?? Client::createWithConfig([]);
        $this->logger = $logger;
    }

    public function sendRequest(RequestInterface $request, array $logContext = []): ResponseInterface
    {
        try {
            $response = $this->httpClient->sendRequest($request);
            LogFactory::log($this->logger, $logContext, $request, $response, null);

            return $response;
        } catch (Throwable $exception) {
            LogFactory::log($this->logger, $logContext, $request, null, $exception);

            throw $exception;
        }
    }
}
