<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

final class AccessTokenPayload extends AbstractPayload
{
    /**
     * @see https://tools.ietf.org/html/rfc7519#section-4.1
     */
    public function __construct(AbstractAudience $aud, int $exp)
    {
        $this->aud = $aud;
        $this->exp = $exp;
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return ['aud' => $this->aud->toArray(), 'exp' => $this->exp];
    }
}
