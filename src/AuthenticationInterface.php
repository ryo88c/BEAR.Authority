<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

use Ray\Aop\MethodInvocation;

interface AuthenticationInterface
{
    public function authenticate(AbstractAudience $audience, MethodInvocation $invocation) : bool;
}
