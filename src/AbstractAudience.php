<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

/**
 * @property int    $id
 * @property string $role
 */
abstract class AbstractAudience
{
    /**
     * @var int
     */
    protected $id;

    /**
     * @var string
     */
    protected $role;

    abstract public function __get(string $name);

    abstract public function toArray() : array;
}
