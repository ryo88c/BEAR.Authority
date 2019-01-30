<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

/**
 * @property int    $id
 * @property string $role
 * @property string $label
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

    /**
     * @var string
     */
    protected $label;

    abstract public function __get(string $name);

    abstract public function toArray() : array;
}
