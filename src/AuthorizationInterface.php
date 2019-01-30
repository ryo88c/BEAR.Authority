<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

interface AuthorizationInterface
{
    public function authorize();

    public function tokenize(AbstractAudience $aud, int $exp = null) : array;

    public function hasToken() : bool;

    public function extractToken() : string;

    public function encodeToken(AbstractPayload $payload, $key = null) : string;

    public function decodeToken($jwt, $key = null);

    public function generatePrivateKey() : string;
}
