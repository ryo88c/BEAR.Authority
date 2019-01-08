<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

class Audience extends AbstractAudience
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $role;

    public function __construct(array $params)
    {
        foreach (['id', 'role'] as $name) {
            if (! array_key_exists($name, $params)) {
                throw new \InvalidArgumentException(sprintf('%s is required in %s', $name, __CLASS__));
            }

            $this->{$name} = $params[$name];
        }
    }

    /**
     * {@inheritdoc}
     */
    public function __get(string $name) : string
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
        return ['id' => $this->id, 'role' => $this->role];
    }
}
