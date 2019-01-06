<?php
namespace Ryo88c\Authority;

/**
 * Interface PayloadInterface
 *
 * @property Audience $aud
 * @property int      $exp
 */
interface PayloadInterface
{
    public function __get($name);

    public function toArray();
}
