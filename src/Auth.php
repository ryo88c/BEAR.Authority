<?php
namespace Ryo88c\Authority;

/**
 * @Annotation
 * @Target("METHOD")
 */
class Auth
{
    public $allow;

    public $deny;
}
