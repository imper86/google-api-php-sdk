<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 17:32
 */

namespace Imper86\GoogleApiPhpSdk;


use Imper86\GoogleApiPhpSdk\Model\Credentials\AppCredentialsInterface;
use Imper86\GoogleApiPhpSdk\Model\TokenBundle\TokenBundleInterface;

interface AuthServiceInterface
{
    public function createAuthUrl(
        AppCredentialsInterface $credentials,
        array $scopes = [],
        string $accessType = 'offline',
        array $additionalParameters = []
    ): string;

    public function fetchTokenFromCode(AppCredentialsInterface $credentials, string $code): TokenBundleInterface;

    public function fetchTokenFromRefresh(AppCredentialsInterface $credentials, string $refreshToken): TokenBundleInterface;

    public function revokeToken(string $token): void;
}
