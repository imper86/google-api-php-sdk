<?php

namespace Imper86\GoogleApiPhpSdk\Model\Request\PhotosLibrary;

use GuzzleHttp\Psr7\Request;
use Imper86\GoogleApiPhpSdk\Constants\EndpointUri;
use Imper86\GoogleApiPhpSdk\Model\Request\RequestTrait;

class GetMediaItemsListRequestV1 extends Request
{
    use RequestTrait;

    public function __construct($token, array $queryParameters = [])
    {
        parent::__construct(
            'GET',
            sprintf('%s/v1/mediaItems?%s', EndpointUri::API_PHOTOS_LIBRARY, http_build_query($queryParameters)),
            $this->prepareHeaders($token)
        );
    }
}
