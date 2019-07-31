<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 18:34
 */

namespace Imper86\GoogleApiPhpSdk\Model\Request\Drive;


use GuzzleHttp\Psr7\Request;
use Imper86\GoogleApiPhpSdk\Constants\EndpointUri;
use Imper86\GoogleApiPhpSdk\Model\Request\RequestTrait;

class GetFilesRequestV1 extends Request
{
    use RequestTrait;

    public function __construct($token, array $queryParameters = [])
    {
        parent::__construct(
            'GET',
            EndpointUri::API . '/drive/v3/files?' . http_build_query($queryParameters),
            $this->prepareHeaders($token)
        );
    }
}
