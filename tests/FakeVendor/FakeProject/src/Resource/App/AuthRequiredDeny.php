<?php
namespace FakeVendor\FakeProject\Resource\App;

use BEAR\Resource\ResourceObject;
use Ryo88c\Authority\Auth;

class AuthRequiredDeny extends ResourceObject
{
    /**
     * @Auth(deny="guest")
     */
    public function onGet()
    {
        return $this;
    }

    /**
     * @Auth(deny="guest")
     */
    public function onPost()
    {
        return $this;
    }
}
