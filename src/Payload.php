<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

class Payload implements PayloadInterface
{
    /**
     * @var AudienceInterface
     */
    private $aud;

    /**
     * @var int
     */
    private $exp;

    /**
     * Payload constructor.
     *
     * @see https://tools.ietf.org/html/rfc7519#section-4.1
     */
    public function __construct(AudienceInterface $aud, int $exp)
    {
        $this->aud = $aud;
        $this->exp = $exp;
    }

    public function __get($name)
    {
        if (! isset($this->{$name})) {
            throw new \InvalidArgumentException(sprintf('%s in undefined.', $name));
        }

        return $this->{$name};
    }

    public function toArray() : array
    {
        return ['aud' => $this->aud->toArray(), 'exp' => $this->exp];
    }
}
