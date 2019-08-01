<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 17:36
 */

namespace Imper86\GoogleApiPhpSdk\Model\TokenBundle;


use DateTime;
use Lcobucci\JWT\Token;

interface TokenBundleInterface
{
    public function getAccessToken(): ?string;

    public function getRefreshToken(): ?string;

    public function setRefreshToken(?string $refreshToken): void;

    public function getCreatedAt(): ?DateTime;

    public function setCreatedAt(?DateTime $createdAt): void;

    public function getExpiresAt(): ?DateTime;

    public function isExpired(): bool;

    public function getIdToken(): ?Token;

    public function toJson(): string;
}
