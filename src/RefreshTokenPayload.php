<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

final class RefreshTokenPayload extends AbstractPayload
{
    /**
     * @var AbstractAudience
     */
    protected $aud;

    /**
     * @var int
     */
    protected $createdAt;

    public function __construct(AbstractAudience $aud)
    {
        $this->aud = $aud;
        $this->createdAt = time();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return ['aud' => $this->aud->toArray(), 'createdAt' => $this->createdAt];
    }
}
