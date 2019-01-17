<?php
namespace FakeVendor\FakeProject\Module;

use BEAR\Resource\Module\ResourceModule;
use Ray\Di\AbstractModule;
use Ryo88c\Authority\Module;

class AppModule extends AbstractModule
{
    /**
     * {@inheritDoc}
     */
    protected function configure()
    {
        $this->install(new ResourceModule('FakeVendor\FakeProject'));
        $this->install(new Module);
    }
}
