<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

/**
 * Interface AudienceInterface
 *
 * @property int    $id
 * @property string $role
 */
interface AudienceInterface
{
    public function __get($name);

    public function toArray();
}
