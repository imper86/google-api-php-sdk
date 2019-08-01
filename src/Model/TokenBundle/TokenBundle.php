<?php
/**
 * Copyright: IMPER.INFO Adrian Szuszkiewicz
 * Date: 31.07.2019
 * Time: 17:41
 */

namespace Imper86\GoogleApiPhpSdk\Model\TokenBundle;


use DateInterval;
use DateTime;
use InvalidArgumentException;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\Token;

class TokenBundle implements TokenBundleInterface
{
    /**
     * @var array
     */
    private $tokenBody;

    public function __construct(string $jsonToken)
    {
        $this->tokenBody = json_decode($jsonToken, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            throw new InvalidArgumentException(json_last_error_msg(), json_last_error());
        }
    }

    public function getAccessToken(): ?string
    {
        return $this->tokenBody['access_token'] ?? null;
    }

    public function getRefreshToken(): ?string
    {
        return $this->tokenBody['refresh_token'] ?? null;
    }

    public function setRefreshToken(?string $refreshToken): void
    {
        $this->tokenBody['refresh_token'] = $refreshToken;
    }

    public function getCreatedAt(): ?DateTime
    {
        $createdAt = $this->tokenBody['created'] ?? null;

        return $createdAt ? new DateTime('@' . $createdAt) : null;
    }

    public function setCreatedAt(?DateTime $createdAt): void
    {
        $this->tokenBody['created'] = $createdAt ? $createdAt->getTimestamp() : null;
    }

    public function getExpiresAt(): ?DateTime
    {
        $createdAt = $this->getCreatedAt();
        $expiresIn = $this->tokenBody['expires_in'] ?? 0;

        return $createdAt ? $createdAt->add(new DateInterval("PT{$expiresIn}S")) : null;
    }

    public function isExpired(): bool
    {
        $expiresAt = $this->getExpiresAt();

        return $expiresAt ? $expiresAt < new DateTime() : true;
    }

    public function getIdToken(): ?Token
    {
        $idTokenString = $this->tokenBody['id_token'];
        $parser = new Parser();

        return $idTokenString ? $parser->parse($idTokenString) : null;
    }

    public function toJson(): string
    {
        return json_encode($this->tokenBody);
    }
}
