<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Auth
{
    /**
     * @var string
     */
    public $allow;

    /**
     * @var string
     */
    public $deny;
}
