<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

final class RefreshTokenPayload extends AbstractPayload
{
    protected $accessToken;

    public function __construct(string $accessToken)
    {
        $this->accessToken = $accessToken;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return ['accessToken' => $this->accessToken];
    }
}
