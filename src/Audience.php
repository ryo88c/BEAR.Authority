<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

class Audience implements AudienceInterface
{
    private $id;

    private $role;

    public function __construct($params)
    {
        foreach (['id', 'role'] as $name) {
            if (! array_key_exists($name, $params)) {
                throw new \InvalidArgumentException(sprintf('%s is required in %s', $name, __CLASS__));
            }

            $this->{$name} = $params[$name];
        }
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
        return ['id' => $this->id, 'role' => $this->role];
    }
}
