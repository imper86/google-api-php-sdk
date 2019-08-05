<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 05.08.2019
 * Time: 14:41
 */

namespace Imper86\GoogleApiPhpSdk\Model\Request\Spreadsheets;


use GuzzleHttp\Psr7\Request;
use Imper86\GoogleApiPhpSdk\Constants\EndpointUri;
use Imper86\GoogleApiPhpSdk\Model\Request\RequestTrait;
use function GuzzleHttp\Psr7\build_query;

class GetSpreadsheetValuesRequestV1 extends Request
{
    use RequestTrait;

    public function __construct($token, string $spreadshetId, string $range, array $queryParameters = [])
    {
        parent::__construct(
            'GET',
            EndpointUri::API_SHEETS . "/v4/spreadsheets/{$spreadshetId}/values/{$range}?" . build_query($queryParameters),
            $this->prepareHeaders($token)
        );
    }
}
