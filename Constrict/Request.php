<?php

namespace Http\Constrict;

use Http\FileInterface;
use Http\Handler\AuthorizationInterface;
use Http\Message\Response;
use Http\Message\ServerRequest;
use Http\Message\Uploaded;
use JetBrains\PhpStorm\Pure;
use Kiri\Context;
use Kiri\Kiri;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\UriInterface;


class Request implements RequestInterface
{


	/**
	 * @return ServerRequest
	 */
	private function __call__(): ServerRequest
	{
		return Context::getContext(RequestInterface::class, new ServerRequest());
	}


	/**
	 * @param string $name
	 * @param array $arguments
	 * @return mixed
	 */
	public function __call(string $name, array $arguments)
	{
		return $this->__call__()->{$name}(...$arguments);
	}


	/**
	 * @param $name
	 * @return mixed
	 */
	public function __get($name): mixed
	{
		// TODO: Change the autogenerated stub
		return $this->__call__()->{$name};
	}


	/**
	 * @param \Swoole\Http\Request $request
	 * @return Request
	 * @throws \Exception
	 */
	public static function create(\Swoole\Http\Request $request): Request
	{
		$serverRequest = ServerRequest::createServerRequest($request);

		Context::setContext(ResponseInterface::class, new Response());

		Context::setContext(RequestInterface::class, $serverRequest);

		return Kiri::getDi()->get(Request::class);
	}


	/**
	 * @return string
	 */
	public function getProtocolVersion(): string
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @param string $version
	 * @return Request
	 */
	public function withProtocolVersion($version): RequestInterface
	{
		return $this->__call__()->{__FUNCTION__}($version);
	}


	/**
	 * @return \string[][]
	 */
	public function getHeaders(): array
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasHeader($name): bool
	{
		return $this->__call__()->{__FUNCTION__}($name);
	}


	/**
	 * @param string $name
	 * @return string[]
	 */
	public function getHeader($name): array
	{
		return $this->__call__()->{__FUNCTION__}($name);
	}


	/**
	 * @param string $name
	 * @return string
	 */
	public function getHeaderLine($name): string
	{
		return $this->__call__()->{__FUNCTION__}($name);
	}


	/**
	 * @param string $name
	 * @param string|string[] $value
	 * @return Request
	 */
	public function withHeader($name, $value): RequestInterface
	{
		return $this->__call__()->{__FUNCTION__}($name, $value);
	}


	/**
	 * @param string $name
	 * @param string|string[] $value
	 * @return Request
	 */
	public function withAddedHeader($name, $value): RequestInterface
	{
		return $this->__call__()->{__FUNCTION__}($name, $value);
	}


	/**
	 * @param string $name
	 * @return Request
	 */
	public function withoutHeader($name): RequestInterface
	{
		return $this->__call__()->{__FUNCTION__}($name);
	}


	/**
	 * @return StreamInterface
	 */
	public function getBody(): StreamInterface
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @param StreamInterface $body
	 * @return Request
	 */
	public function withBody(StreamInterface $body): RequestInterface
	{
		return $this->__call__()->{__FUNCTION__}($body);
	}


	/**
	 * @return string
	 */
	public function getRequestTarget(): string
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @param mixed $requestTarget
	 * @return Request
	 */
	public function withRequestTarget($requestTarget): RequestInterface
	{
		return $this->__call__()->{__FUNCTION__}($requestTarget);
	}


	/**
	 * @return string
	 */
	public function getMethod(): string
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @param string $method
	 * @return bool
	 */
	public function isMethod(string $method): bool
	{
		return $this->__call__()->{__FUNCTION__}($method);
	}


	/**
	 * @param string $method
	 * @return Request
	 */
	public function withMethod($method): RequestInterface
	{
		return $this->__call__()->{__FUNCTION__}($method);
	}


	/**
	 * @return UriInterface
	 */
	public function getUri(): UriInterface
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @param UriInterface $uri
	 * @param false $preserveHost
	 * @return Request
	 */
	public function withUri(UriInterface $uri, $preserveHost = false): RequestInterface
	{
		return $this->__call__()->{__FUNCTION__}($uri, $preserveHost);
	}


	/**
	 * @param string $name
	 * @return FileInterface|null
	 */
	public function file(string $name): ?FileInterface
	{
		$files = $this->__call__()->getUploadedFiles();
		if (empty($files) || !isset($files[$name])) {
			return null;
		}
		return new Uploaded($files[$name]['tmp_name'], $files[$name]['name'], $files[$name]['type'],
			$files[$name]['size'], $files[$name]['error']);
	}


	/**
	 * @return array
	 */
	public function getHeaderArray(): array
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @param string|null $name
	 * @param mixed|null $default
	 * @return mixed
	 */
	private function _getParsedBody(string|null $name = null, mixed $default = null): mixed
	{
		$body = $this->__call__()->getParsedBody();
		if (empty($name)) {
			return $body;
		}
		return $body[$name] ?? $default;
	}


	/**
	 * @param array $filters
	 * @return Validator
	 * @throws \Exception
	 */
	public function validator(array $filters): Validator
	{
		$validator = \validator\Validator::getInstance();
		$validator->setParams($this->getParsedBody());
		foreach ($filters as $val) {
			$field = array_shift($val);
			if (!empty($val)) {
				$validator->make($field, $val);
			}
		}
		return new Validator($validator->validation(), $validator->getError());
	}


	/**
	 * @return array
	 */
	public function all(): array
	{
		return $this->_getParsedBody();
	}


	/**
	 * @param string $name
	 * @param bool|int|string|null $default
	 * @return mixed
	 */
	public function query(string $name, bool|int|string|null $default = null): mixed
	{
		$files = $this->__call__()->getQueryParams();

		return $files[$name] ?? $default;
	}


	/**
	 * @param string $name
	 * @param int|bool|array|string|null $default
	 * @return mixed
	 */
	public function post(string $name, int|bool|array|string|null $default = null): mixed
	{
		return $this->_getParsedBody($name, $default);
	}


	/**
	 * @param string $name
	 * @param bool $required
	 * @return int|null
	 * @throws \Exception
	 */
	public function int(string $name, bool $required = false): ?int
	{
		$int = $this->_getParsedBody($name);
		if (is_null($int) && $required) {
			throw new \Exception('Required param "' . $name . '"');
		}
		return (int)$int;
	}


	/**
	 * @param string $name
	 * @param bool $required
	 * @return float|null
	 * @throws \Exception
	 */
	public function float(string $name, bool $required = false): ?float
	{
		$int = $this->_getParsedBody($name);
		if (is_null($int) && $required) {
			throw new \Exception('Required param "' . $name . '"');
		}
		return (float)$int;
	}


	/**
	 * @param string $name
	 * @param bool $required
	 * @return string|null
	 * @throws \Exception
	 */
	public function date(string $name, bool $required = false): ?string
	{
		$int = $this->_getParsedBody($name);
		if (is_null($int) && $required) {
			throw new \Exception('Required param "' . $name . '"');
		}
		return (string)$int;
	}


	/**
	 * @param string $name
	 * @param bool $required
	 * @return int|null
	 * @throws \Exception
	 */
	public function timestamp(string $name, bool $required = false): ?int
	{
		$int = $this->_getParsedBody($name);
		if (is_null($int) && $required) {
			throw new \Exception('Required param "' . $name . '"');
		}
		return (int)$int;
	}


	/**
	 * @param string $name
	 * @param bool $required
	 * @return string|null
	 * @throws \Exception
	 */
	public function string(string $name, bool $required = false): ?string
	{
		$int = $this->_getParsedBody($name);
		if (is_null($int) && $required) {
			throw new \Exception('Required param "' . $name . '"');
		}
		return (string)$int;
	}


	/**
	 * @param string $name
	 * @param array $default
	 * @return array|null
	 */
	public function array(string $name, array $default = []): ?array
	{
		$int = $this->_getParsedBody($name);
		if (is_null($int)) {
			return $default;
		}
		return $int;
	}


	/**
	 * @return array|null
	 */
	public function gets(): ?array
	{
		return $this->__call__()->getQueryParams();
	}


	/**
	 * @param string $field
	 * @param string $sizeField
	 * @param int $max
	 * @return float|int
	 */
	public function offset(string $field = 'page', string $sizeField = 'size', int $max = 100): float|int
	{
		$page = $this->query($field, 1);
		$size = $this->size($sizeField, $max);
		$offset = ($page - 1) * $size;
		if ($offset < 0) {
			$offset = 0;
		}
		return $offset;
	}


	/**
	 * @param string $field
	 * @param int $max
	 * @return int
	 */
	public function size(string $field = 'size', int $max = 100): int
	{
		$size = $this->query($field, 20);
		if ($size > $max) {
			$size = $max;
		}
		return (int)$size;
	}


	/**
	 * @param $name
	 * @param null $default
	 * @return mixed
	 */
	public function input($name, $default = null): mixed
	{
		return $this->_getParsedBody($name, $default);
	}


	/**
	 * @return float
	 */
	#[Pure] public function getStartTime(): float
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @param AuthorizationInterface $authority
	 */
	public function setAuthority(AuthorizationInterface $authority): void
	{
		$this->__call__()->{__FUNCTION__}($authority);
	}


	/**
	 * @return int
	 */
	public function getClientId(): int
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @return string|null
	 */
	#[Pure] public function getAccessControlAllowOrigin(): ?string
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @return string|null
	 */
	#[Pure] public function getAccessControlAllowHeaders(): ?string
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @return string|null
	 */
	#[Pure] public function getAccessControlRequestMethod(): ?string
	{
		return $this->__call__()->{__FUNCTION__}();
	}
}