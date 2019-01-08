<?php

declare(strict_types=1);

namespace Ryo88c\Authority;

use Aura\Web\Request;
use Firebase\JWT\JWT;
use Ray\Di\Di\Named;

class Authorization implements AuthorizationInterface
{
    private $request;

    private $config;

    /**
     * Authorization constructor.
     *
     * @param Request $request Request
     * @param array   $config  Configuration
     *
     * @Named("config=authorization_config")
     */
    public function __construct(Request $request, array $config)
    {
        $this->request = $request;
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public function authorize() : AbstractAudience
    {
        $payload = $this->decodeToken($this->extractToken());

        return $payload->aud;
    }

    /**
     * {@inheritdoc}
     */
    public function tokenize(AbstractAudience $aud, int $exp = null) : string
    {
        if (empty($exp)) {
            $exp = time() + 1800;
        }

        return $this->encodeToken(new Payload($aud, $exp));
    }

    public function encodeToken(PayloadInterface $payload) : string
    {
        return JWT::encode($payload->toArray(), $this->getPrivateKey(), $this->config['jwt']['algorithm']);
    }

    public function decodeToken($jwt) : PayloadInterface
    {
        $payload = (array) JWT::decode($jwt, $this->getPrivateKey(), [$this->config['jwt']['algorithm']]);

        return new Payload(new Audience((array) $payload['aud']), $payload['exp']);
    }

    private function getPrivateKey() : string
    {
        if (! file_exists($this->config['privateKey']['filePath'])) {
            file_put_contents($this->config['privateKey']['filePath'], $this->generatePrivateKey());
        }

        return $this->fileGetContests($this->config['privateKey']['filePath']);
    }

    private function generatePrivateKey() : string
    {
        $keyResource = openssl_pkey_new($this->config['openssl']);
        if (! is_resource($keyResource)) {
            throw new \RuntimeException;
        }
        openssl_pkey_export($keyResource, $privateKey);

        return $privateKey;
    }

    private function extractToken()
    {
        $token = null;
        $header = (string) $this->request->headers->get('authorization');
        if (preg_match('!Bearer\s+(.*)\z!i', $header, $matches)) {
            $token = $matches[1];
        }
        $method = $this->request->method->get();
        if ('POST' === $method) {
            $tokenOnPost = $this->request->post->get('accessToken');
            if (empty($tokenOnPost)) {
                $tokenOnPost = $this->request->post->get('access_token');
            }
            if (null !== $tokenOnPost) {
                if (null !== $token) {
                    throw new DuplicateAccessTokenException;
                }
                $token = $tokenOnPost;
            }
        }

        $tokenOnGet = $this->request->query->get('accessToken');
        if (empty($tokenOnGet)) {
            $tokenOnGet = $this->request->query->get('access_token');
        }
        if (null !== $tokenOnGet) {
            if (null !== $token) {
                throw new DuplicateAccessTokenException;
            }
            $token = $tokenOnGet;
        }

        if (empty($token)) {
            throw new TokenNotFoundException;
        }

        return $token;
    }

    private function fileGetContests(string $file) : string
    {
        $fileContents = \file_get_contents($file);
        if (\is_string($fileContents)) {
            return $file;
        }

        throw new \RuntimeException($file);
    }
}
