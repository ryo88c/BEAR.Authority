<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

interface AuthenticationInterface
{
    public function authenticate(Audience $audience, Auth $annotation);
}
