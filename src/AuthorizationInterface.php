<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

interface AuthorizationInterface
{
    public function authorize() : AbstractAudience;

    public function tokenize(AbstractAudience $aud, int $exp = null) : array;
}
