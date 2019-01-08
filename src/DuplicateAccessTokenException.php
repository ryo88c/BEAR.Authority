<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

use BEAR\Resource\Exception\BadRequestException;

class DuplicateAccessTokenException extends BadRequestException
{
    protected $message = 'Token must not be contain as multiple in a request.';
}
