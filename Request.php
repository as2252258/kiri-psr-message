<?php

namespace Kiri\Message;

use BadMethodCallException;
use Kiri\Message\Handler\AuthorizationInterface;
use JetBrains\PhpStorm\Pure;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;


/**
 *
 */
class Request implements RequestInterface
{

	use Message;


	/**
	 * @var UriInterface
	 */
	protected UriInterface $uriInterface;


	/**
	 * @var string
	 */
	protected string $method;


	/**
	 * @var AuthorizationInterface|null
	 */
	public ?AuthorizationInterface $authority = null;


	/**
	 * @param AuthorizationInterface|null $authIdentity
	 */
	public function setAuthority(?AuthorizationInterface $authIdentity): void
	{
		$this->authority = $authIdentity;
	}


	/**
	 * @return string
	 */
	public function getRequestTarget(): string
	{
		throw new BadMethodCallException('Not Accomplish Method.');
	}


	/**
	 * @param mixed $requestTarget
	 * @return static
	 */
	public function withRequestTarget($requestTarget): static
	{
		throw new BadMethodCallException('Not Accomplish Method.');
	}


	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->method;
	}


	/**
	 * @param string $method
	 * @return RequestInterface
	 */
	public function withMethod(string $method): RequestInterface
	{
		$this->method = $method;
		return $this;
	}


	/**
	 * @param string $method
	 * @return bool
	 */
	public function isMethod(string $method): bool
	{
		return $this->method == $method;
	}


    /**
     * @return string|null
     */
    #[Pure] public function getRequestIp(): ?string
    {
        $headers = $this->getHeaders();
        if (!empty($headers['x-forwarded-for'])) return $headers['x-forwarded-for'][0] ?? null;
        if (!empty($headers['request-ip'])) return $headers['request-ip'][0] ?? null;
        if (!empty($headers['remote_addr'])) return $headers['remote_addr'][0] ?? null;
        return NULL;
    }


	/**
	 * @return UriInterface
	 */
	public function getUri(): UriInterface
	{
		return $this->uriInterface;
	}


	/**
	 * @param UriInterface $uri
	 * @param false $preserveHost
	 * @return $this|Request
	 */
	public function withUri(UriInterface $uri, $preserveHost = false): RequestInterface
	{
		$this->uriInterface = $uri;
		return $this;
	}
}
