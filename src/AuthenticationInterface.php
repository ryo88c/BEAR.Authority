<?php
namespace Ryo88c\Authority;

interface AuthenticationInterface
{
    public function authenticate(Audience $audience, Auth $annotation);
}
