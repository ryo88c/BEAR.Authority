<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

/**
 * Interface PayloadInterface
 *
 * @property Audience $aud
 * @property int      $exp
 */
interface PayloadInterface
{
    public function __get(string $name) : AbstractAudience;

    public function toArray() : array;
}
