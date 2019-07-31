<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 19:20
 */

namespace Imper86\GoogleApiPhpSdk\Model\Request\Spreadsheets;


use GuzzleHttp\Psr7\Request;
use Imper86\GoogleApiPhpSdk\Constants\EndpointUri;
use Imper86\GoogleApiPhpSdk\Model\Request\RequestTrait;

class GetSpreadsheetRequestV1 extends Request
{
    use RequestTrait;

    public function __construct($token, string $spreadsheetId, array $queryParameters = [])
    {
        parent::__construct(
            'GET',
            EndpointUri::API_SHEETS . "/v4/spreadsheets/{$spreadsheetId}?" . http_build_query($queryParameters),
            $this->prepareHeaders($token)
        );
    }
}
