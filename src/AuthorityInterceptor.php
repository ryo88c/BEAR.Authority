<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

use BEAR\Resource\Exception\BadRequestException;
use BEAR\Resource\ResourceObject;
use Firebase\JWT\ExpiredException;
use Koriym\HttpConstants\StatusCode;
use Ray\Aop\MethodInterceptor;
use Ray\Aop\MethodInvocation;
use Ray\Di\Di\Named;

final class AuthorityInterceptor implements MethodInterceptor
{
    /**
     * @var AuthorizationInterface
     */
    private $authorization;

    /**
     * @var AuthenticationInterface
     */
    private $authentication;

    /**
     * @var array
     */
    private $config;

    /**
     * @Named("config=authority_config")
     */
    public function __construct(
        AuthorizationInterface $authorization,
        AuthenticationInterface $authentication,
        array $config
    ) {
        $this->authorization = $authorization;
        $this->authentication = $authentication;
        $this->config = $config;
    }

    public function invoke(MethodInvocation $invocation)
    {
        $caller = $invocation->getThis();
        try {
            if (! ($caller instanceof ResourceObject)) {
                throw new \LogicException('Caller must be ResourceObject.');
            }
            if (! $this->authentication->authenticate($this->authorization->authorize(), $invocation)) {
                throw new PermissionDeniedException('You do not have a permission to access.');
            }

            return $invocation->proceed();
        } catch (TokenNotFoundException $e) {
            $caller->code = StatusCode::UNAUTHORIZED;
            $this->error($caller);
        } catch (ExpiredException $e) {
            $caller->code = StatusCode::UNAUTHORIZED;
            $this->error($caller, 'invalid_token', $e->getMessage());
        } catch (DuplicateAccessTokenException $e) {
            $caller->code = StatusCode::BAD_REQUEST;
            $this->error($caller, 'invalid_request', $e->getMessage());
        } catch (PermissionDeniedException $e) {
            $caller->code = StatusCode::FORBIDDEN;
            $this->error($caller, 'insufficient_scope', $e->getMessage());
        } catch (\InvalidArgumentException $e) {
            $caller->code = StatusCode::INTERNAL_SERVER_ERROR;

            throw new BadRequestException($e->getMessage(), $caller->code);
        }
    }

    public function error(ResourceObject &$ro, $error = null, $description = null) : void
    {
        $ro->headers['WWW-Authenticate'] = sprintf('Bearer realm="%s"', $this->config['realm']);
        if (! empty($error)) {
            $ro->headers['WWW-Authenticate'] .= sprintf(',error="%s"', $error);
        }
        if (! empty($description)) {
            $ro->headers['WWW-Authenticate'] .= sprintf(',error_description="%s"', $description);
        }
    }
}
