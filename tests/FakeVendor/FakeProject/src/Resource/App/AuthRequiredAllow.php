<?php
namespace FakeVendor\FakeProject\Resource\App;

use BEAR\Resource\ResourceObject;
use Ryo88c\Authority\Auth;

class AuthRequiredAllow extends ResourceObject
{
    /**
     * @Auth(allow="admin")
     */
    public function onGet()
    {
        return $this;
    }

    /**
     * @Auth(allow="admin")
     */
    public function onPost()
    {
        return $this;
    }
}
