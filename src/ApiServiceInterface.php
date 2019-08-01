<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 18:27
 */

namespace Imper86\GoogleApiPhpSdk;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;

interface ApiServiceInterface
{
    public function sendRequest(RequestInterface $request, array $logContext = []): ResponseInterface;
}
