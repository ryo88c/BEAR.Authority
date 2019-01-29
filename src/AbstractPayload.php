<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

/**
 * @property AbstractAudience $aud
 * @property int $exp
 */
abstract class AbstractPayload
{
    /**
     * @var AbstractAudience
     */
    protected $aud;

    /**
     * @var int
     */
    protected $exp;

    abstract public function __get(string $name);

    abstract public function toArray() : array;
}
