<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

abstract class AbstractAudience
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $role;

    abstract public function __get(string $name) : string;

    abstract public function toArray() : array;
}