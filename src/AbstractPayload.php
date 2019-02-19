<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

/**
 * @property AbstractAudience $aud
 * @property int $exp
 */
abstract class AbstractPayload
{
    protected $isRefreshToken = false;

    /**
     * {@inheritdoc}
     */
    public function __get(string $name)
    {
        if (! isset($this->{$name})) {
            throw new \InvalidArgumentException(sprintf('%s in undefined.', $name));
        }

        return $this->{$name};
    }

    abstract public function toArray() : array;
}
