<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 18:34
 */

namespace Imper86\GoogleApiPhpSdk\Model\Request;


use Imper86\GoogleApiPhpSdk\Model\TokenBundle\TokenBundleInterface;
use InvalidArgumentException;
use stdClass;

trait RequestTrait
{
    private function prepareHeaders($token): array
    {
        if ($token instanceof TokenBundleInterface) {
            $accessToken = $token->getAccessToken();
        } elseif (is_array($token)) {
            $accessToken = $token['access_token'];
        } elseif ($token instanceof stdClass) {
            $accessToken = $token->access_token;
        } elseif ('string' === gettype($token)) {
            $accessToken = $token;
        } else {
            throw new InvalidArgumentException("Provided token is invalid");
        }

        return [
            'Authorization' => "Bearer {$accessToken}",
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }
}
