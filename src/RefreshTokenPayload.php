<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

final class RefreshTokenPayload extends AbstractPayload
{
    protected $isRefreshToken = true;

    protected $aud;

    public function __construct(AbstractAudience $aud)
    {
        $this->aud = $aud;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return ['aud' => $this->aud, 'isRefreshToken' => $this->isRefreshToken];
    }
}
