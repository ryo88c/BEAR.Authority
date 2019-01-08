<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

interface AuthorizationInterface
{
    public function authorize();

    public function tokenize(AudienceInterface $aud, int $exp = null);
}
