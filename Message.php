<?php

namespace Kiri\Message;

use JetBrains\PhpStorm\Pure;
use Kiri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;


/**
 *
 */
trait Message
{

	/**
	 * @var string
	 */
	protected string $version;


	/**
	 * @var StreamInterface|null
	 */
	protected ?StreamInterface $stream = null;


	/**
	 * @var array
	 */
	protected array $headers = [];


	/**
	 * @var array<Cookie>
	 */
	protected array $cookieParams = [];


	/**
	 * @return string
	 */
	public function getProtocolVersion(): string
	{
		return $this->version;
	}


	/**
	 * @return array
	 */
	public function getHeaderArray(): array
	{
		$array = [];
		foreach ($this->headers as $key => $header) {
			$array[$key] = implode(';', $header);
		}
		return $array;
	}


	/**
	 * @param $version
	 * @return static
	 */
	public function withProtocolVersion($version): static
	{
		$this->version = $version;
		return $this;
	}

	/**
	 * @return array
	 */
	public function getHeaders(): array
	{
		return $this->headers;
	}


	/**
	 * @param $name
	 * @return bool
	 */
	public function hasHeader($name): bool
	{
		return array_key_exists($name, $this->headers);
	}


	/**
	 * @param $name
	 * @return string|array|null
	 */
	#[Pure] public function getHeader($name): string|null|array
	{
		if (!$this->hasHeader($name)) {
			return null;
		}
		return $this->headers[$name];
	}


	/**
	 * @return array
	 */
	public function parse_curl_header(): array
	{
		$_headers = [];
		foreach ($this->headers as $key => $val) {
			$_headers[] = $key . ': ' . implode(';', $val);
		}
		return $_headers;
	}


	/**
	 * @throws \Exception
	 */
	public function withData(string $headerString): static
	{
		$headers = explode("\r\n\r\n", $headerString);
		if (isset($headers[1])) {
			$this->stream = new Stream();
			$this->stream->write($headers[1]);
		}
		return $this->slip_headers($headers[0]);
	}


	/**
	 * @param $headers
	 * @return $this
	 * @throws \Exception
	 */
	private function slip_headers($headers): static
	{
		$headers = explode("\r\n", $headers);

		$this->resolve_status(array_shift($headers));

		foreach ($headers as $header) {
			$keyValue = explode(': ', $header);
			if (!isset($keyValue[1])) {
				$keyValue[1] = '';
			}
			$this->withHeader(...$keyValue);
		}
		return $this;
	}


	/**
	 * @param string $protocol
	 */
	private function resolve_status(string $protocol): void
    {
		if ($this instanceof ResponseInterface) {
			[$sch, $status, $message] = explode(' ', $protocol);
			[$sch, $protocolVersion] = explode('/', $sch);
			$this->withProtocolVersion($protocolVersion)
				->withStatus(intval($status));
		}
	}


	/**
	 * @param $key
	 * @param $value
	 */
	private function addRequestHeader($key, $value): void
    {
		$this->headers[$key] = [$value];
	}


	/**
	 * @param $name
	 * @return string
	 */
	#[Pure] public function getHeaderLine($name): string
	{
		if ($this->hasHeader($name)) {
			if (!is_array($this->headers[$name])) {
				return $this->headers[$name];
			}
			return implode(';', $this->headers[$name]);
		}
		return '*';
	}


	/**
	 * @return string|null
	 */
	#[Pure] public function getContentType(): ?string
	{
		return $this->getHeaderLine('Content-Type');
	}


	/**
	 * @param $name
	 * @param $value
	 * @return static
	 */
	public function withHeader($name, $value): static
	{
		if (is_array($value)) {
			$this->headers[$name] = $value;
		} else {
			$this->headers[$name] = [$value];
		}
		return $this;
	}


	/**
	 * @param array $headers
	 * @return static
	 */
	public function withHeaders(array $headers): static
	{
		$this->headers = $headers;
		return $this;
	}


	/**
	 * @param $name
	 * @param $value
	 * @return static
	 * @throws
	 */
	public function withAddedHeader($name, $value): static
	{
		if (!array_key_exists($name, $this->headers)) {
			throw new \Exception('Headers `' . $name . '` not exists.');
		}
		$this->headers[$name][] = $value;
		return $this;
	}


	/**
	 * @param $name
	 * @return static
	 */
	public function withoutHeader($name): static
	{
		unset($this->headers[$name]);
		return $this;
	}


	/**
	 * @return array
	 */
	public function getCookieParams(): array
	{
		return $this->cookieParams;
	}


	/**
	 * @param array|null $cookies
	 * @return static
	 */
	public function withCookieParams(?array $cookies): static
	{
		$this->cookieParams = $cookies;
		return $this;
	}

	/**
	 * @return StreamInterface
	 */
	public function getBody(): StreamInterface
	{
		if (!$this->stream) {
			$this->stream = new Stream('');
		}
		return $this->stream;
	}


	/**
	 * @param StreamInterface $body
	 * @return static
	 */
	public function withBody(StreamInterface $body): static
	{
		$this->stream = $body;
		return $this;
	}


	/**
	 * @return string
	 */
	#[Pure] public function getAccessControlAllowOrigin(): string
	{
		return $this->getHeaderLine('Access-Control-Allow-Origin');
	}


	/**
	 * @return string
	 */
	#[Pure] public function getAccessControlAllowHeaders(): string
	{
		return $this->getHeaderLine('Access-Control-Allow-Headers');
	}


	/**
	 * @return string
	 */
	#[Pure] public function getAccessControlRequestMethod(): string
	{
		return $this->getHeaderLine('Access-Control-Request-Method');
	}

}
