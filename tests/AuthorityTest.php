<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

use BEAR\Resource\Resource;
use BEAR\Resource\ResourceInterface;
use FakeVendor\FakeProject\Module\AppModule;
use Koriym\HttpConstants\StatusCode;
use PHPUnit\Framework\TestCase;
use Ray\Di\Injector;

class AuthorityTest extends TestCase
{
    /**
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * @var string
     */
    private $tmpDir;

    protected function setUp() : void
    {
        unset($_SERVER['HTTP_AUTHORIZATION'], $_SERVER['REQUEST_METHOD'], $_GET['accessToken'], $_POST['accessToken']);

        $this->tmpDir = $_ENV['TMP_DIR'] ?? '';
        $injector = new Injector(new AppModule, $this->tmpDir);
        $this->authorization = $injector->getInstance(AuthorizationInterface::class);
    }

    public function testSuccessAuthorizeByAllow() : void
    {
        $token = $this->authorization->tokenize(new Audience(['id' => 1, 'role' => 'admin']));
        $_SERVER['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $token);

        $resource = (new Injector(new AppModule, $this->tmpDir))->getInstance(ResourceInterface::class);
        /* @var Resource $resource */
        $response = $resource->uri('app://self/authRequiredAllow')->request();

        $this->assertSame(StatusCode::OK, $response->code);
    }

    public function testFailAuthorizeByAllow() : void
    {
        $token = $this->authorization->tokenize(new Audience(['id' => 1, 'role' => 'guest']));
        $_SERVER['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $token);

        $resource = (new Injector(new AppModule, $this->tmpDir))->getInstance(ResourceInterface::class);
        /* @var Resource $resource */
        $response = $resource->uri('app://self/authRequiredAllow')->request();

        $this->assertSame(StatusCode::FORBIDDEN, $response->code);
        $this->assertSame(
            'Bearer realm="Auth required.",error="insufficient_scope",error_description="You do not have a permission to access."',
            $response->headers['WWW-Authenticate']
        );
    }

    public function testFailAuthorizeByAllowWithoutToken() : void
    {
        $resource = (new Injector(new AppModule, $this->tmpDir))->getInstance(ResourceInterface::class);
        /* @var Resource $resource */
        $response = $resource->uri('app://self/authRequiredAllow')->request();

        $this->assertSame(StatusCode::UNAUTHORIZED, $response->code);
        $this->assertSame('Bearer realm="Auth required."', $response->headers['WWW-Authenticate']);
    }

    public function testSuccessAuthorizeByDeny() : void
    {
        $token = $this->authorization->tokenize(new Audience(['id' => 1, 'role' => 'admin']));
        $_SERVER['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $token);

        $resource = (new Injector(new AppModule, $this->tmpDir))->getInstance(ResourceInterface::class);
        /* @var Resource $resource */
        $response = $resource->uri('app://self/authRequiredDeny')->request();

        $this->assertSame(StatusCode::OK, $response->code);
    }

    public function testFailAuthorizeByDeny() : void
    {
        $token = $this->authorization->tokenize(new Audience(['id' => 1, 'role' => 'guest']));
        $_SERVER['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $token);

        $resource = (new Injector(new AppModule, $this->tmpDir))->getInstance(ResourceInterface::class);
        /* @var Resource $resource */
        $response = $resource->uri('app://self/authRequiredDeny')->request();

        $this->assertSame(StatusCode::FORBIDDEN, $response->code);
        $this->assertSame(
            'Bearer realm="Auth required.",error="insufficient_scope",error_description="You do not have a permission to access."',
            $response->headers['WWW-Authenticate']
        );
    }

    public function testFailAuthorizeByDenyWithoutToken() : void
    {
        $resource = (new Injector(new AppModule, $this->tmpDir))->getInstance(ResourceInterface::class);
        /* @var Resource $resource */
        $response = $resource->uri('app://self/authRequiredAllow')->request();

        $this->assertSame(StatusCode::UNAUTHORIZED, $response->code);
        $this->assertSame('Bearer realm="Auth required."', $response->headers['WWW-Authenticate']);
    }

    public function testFailAuthorizeByMultipleToken1() : void
    {
        $token = $this->authorization->tokenize(new Audience(['id' => 1, 'role' => 'admin']));
        $_SERVER['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $token);
        $_GET['accessToken'] = $token;

        $resource = (new Injector(new AppModule, $this->tmpDir))->getInstance(ResourceInterface::class);
        /* @var Resource $resource */
        $response = $resource->uri('app://self/authRequiredAllow')->request();

        $this->assertSame(StatusCode::BAD_REQUEST, $response->code);
    }

    public function testFailAuthorizeByMultipleToken2() : void
    {
        $token = $this->authorization->tokenize(new Audience(['id' => 1, 'role' => 'admin']));
        $_SERVER['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $token);
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_POST['accessToken'] = $token;

        $resource = (new Injector(new AppModule, $this->tmpDir))->getInstance(ResourceInterface::class);
        $response = $resource->post->uri('app://self/authRequiredAllow')->request();

        $this->assertSame(StatusCode::BAD_REQUEST, $response->code);
    }

    public function testFailAuthorizeByMultipleToken3() : void
    {
        $token = $this->authorization->tokenize(new Audience(['id' => 1, 'role' => 'admin']));
        $_SERVER['HTTP_AUTHORIZATION'] = sprintf('Bearer %s', $token);
        $_SERVER['REQUEST_METHOD'] = 'POST';
        $_GET['accessToken'] = $_POST['accessToken'] = $token;

        $resource = (new Injector(new AppModule, $this->tmpDir))->getInstance(ResourceInterface::class);
        $response = $resource->post->uri('app://self/authRequiredAllow')->request();

        $this->assertSame(StatusCode::BAD_REQUEST, $response->code);
    }
}
