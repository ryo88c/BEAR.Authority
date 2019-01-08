<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

final class Payload implements PayloadInterface
{
    /**
     * @var AbstractAudience
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
    public function __construct(AbstractAudience $aud, int $exp)
    {
        $this->aud = $aud;
        $this->exp = $exp;
    }

    /**
     * {@inheritdoc}
     */
    public function __get(string $name) : AbstractAudience
    {
        if (! isset($this->{$name})) {
            throw new \InvalidArgumentException(sprintf('%s in undefined.', $name));
        }

        return $this->{$name};
    }

    /**
     * {@inheritdoc}
     */
    public function toArray() : array
    {
        return ['aud' => $this->aud->toArray(), 'exp' => $this->exp];
    }
}
