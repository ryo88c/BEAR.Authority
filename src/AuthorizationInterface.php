<?php
namespace Ryo88c\Authority;

interface AuthorizationInterface
{
    public function authorize();

    public function tokenize(AudienceInterface $aud, int $exp = null);
}
