<?php
namespace Ryo88c\Authority;

use BEAR\Resource\Exception\BadRequestException;

class DuplicateAccessTokenException extends BadRequestException
{
    protected $message = 'Token must not be contain as multiple in a request.';
}
