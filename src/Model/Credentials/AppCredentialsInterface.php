<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 17:29
 */

namespace Imper86\GoogleApiPhpSdk\Model\Credentials;


/**
 * Interface AppCredentialsInterface
 * @package Imper86\GoogleApiPhpSdk\Model\Credentials
 */
interface AppCredentialsInterface
{
    /**
     * @return string
     */
    public function getClientId(): string;

    /**
     * @return string
     */
    public function getClientSecret(): string;

    /**
     * @return string
     */
    public function getRedirectUri(): string;
}
