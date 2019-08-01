<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 01.08.2019
 * Time: 12:04
 */

namespace Imper86\GoogleApiPhpSdk\Factory;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Throwable;

class LogFactory
{
    public static function log(
        ?LoggerInterface $logger,
        array $context,
        RequestInterface $request,
        ?ResponseInterface $response,
        ?Throwable $exception
    ): void
    {
        if (!$logger) {
            return;
        }

        if (!$response || $response->getStatusCode() > 299 || $exception) {
            $logLevel = 'error';
        } else {
            $logLevel = 'debug';
        }

        $requestBodyIsJson = false !== strpos($request->getHeaderLine('Content-Type'), 'json');
        $responseBodyIsJson = $response && false !== strpos($response->getHeaderLine('Content-Type'), 'json');

        $context['requestMethod'] = $request->getMethod();
        $context['requestUrl'] = (string)$request->getUri();
        $context['requestUriPath'] = $request->getUri()->getPath();
        $context['requestHeaders'] = $request->getHeaders();
        $context['requestQuery'] = $request->getUri()->getQuery();
        $context['requestBody'] = $requestBodyIsJson
            ? json_decode((string)$request->getBody(), true)
            : (string)$request->getBody();
        $context['responseStatusCode'] = $response ? $response->getStatusCode() : 0;
        $context['responseHeaders'] = $response ? $response->getHeaders() : null;
        $context['responseBody'] = $responseBodyIsJson
            ? json_decode((string)$response->getBody(), true)
            : ($response ? (string)$response->getBody() : null);
        $context['backtrace'] = debug_backtrace(DEBUG_BACKTRACE_IGNORE_ARGS);
        $context['requestHash'] = sha1(json_encode([
            $context['requestMethod'],
            $context['requestUriPath'],
            $context['requestQuery'],
            $context['requestBody'],
        ]));

        if (!empty($context['responseBody']['errors'])) {
            $context['faultCode'] = $context['responseBody']['errors'][0]['code'] ?? null;
            $context['faultString'] = $context['responseBody']['errors'][0]['message'] ?? null;
        }

        if ($exception) {
            $context['exceptionCode'] = $exception->getCode();
            $context['exceptionMessage'] = $exception->getMessage();
        }

        $logger->log(
            $logLevel,
            "{$context['requestMethod']} {$context['requestUriPath']} - {$context['responseStatusCode']}",
            $context
        );
    }
}
