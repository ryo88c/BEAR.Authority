<?php
namespace Ryo88c\Authority;

use Ray\AuraWebModule\AuraWebModule;
use Ray\Di\AbstractModule;
use Ray\Di\Scope;

class Module extends AbstractModule
{
    /**
     * {@inheritDoc}
     */
    public function configure()
    {
        $this->install(new AuraWebModule);
        $this->bind()->annotatedWith('authority_config')->toInstance([
            'realm' => $_ENV['REALM'] ?? 'Auth required.'
        ]);
        $this->bind()->annotatedWith('authorization_config')->toInstance([
            'jwt' => ['algorithm' => $_ENV['JWT_ALGORITHM'] ?? 'HS256'],
            'openssl' => [
                'digest_alg' => $_ENV['OPENSSL_ALGORITHM'] ?? 'RS256',
                'private_key_bits' => (int) ($_ENV['OPENSSL_PRIVATE_KEY_BITS'] ?? 1024),
                'private_key_type' => constant($_ENV['OPENSSL_PRIVATE_KEY_TYPE'] ?? 'OPENSSL_KEYTYPE_RSA')
            ],
            'privateKey' => ['filePath' => '/tmp/privateKey']
        ]);
        $this->bind()->annotatedWith('authentication_config')->toInstance([
            'definedRoles' => ['admin', 'guest']
        ]);
        $this->bind(AuthenticationInterface::class)->to(Authentication::class)->in(Scope::SINGLETON);
        $this->bind(AuthorizationInterface::class)->to(Authorization::class)->in(Scope::SINGLETON);
        $this->bindInterceptor(
            $this->matcher->any(),
            $this->matcher->annotatedWith(Auth::class),
            [AuthorityInterceptor::class]
        );
    }
}
