<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

abstract class AbstractPayload
{
    /**
     * @var AbstractAudience
     */
    public $aud;

    /**
     * @var int
     */
    public $exp;

    abstract public function __get(string $name) : AbstractAudience;

    abstract public function toArray() : array;
}
