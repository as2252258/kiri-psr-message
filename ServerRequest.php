<?php

namespace Kiri\Message;

use Kiri\Di\Context;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamInterface;
use Swoole\Http\Request as ShRequest;


/**
 *
 */
class ServerRequest extends Request implements ServerRequestInterface
{


	const PARSE_BODY = 'with.parsed.body.callback';


	/**
	 * @var mixed
	 */
	protected ?array $parsedBody = null;


	/**
	 * @var array|null
	 */
	protected ?array $serverParams;


	/**
	 * @var array|null
	 */
	protected ?array $queryParams;

	/**
	 * @var array|null
	 */
	protected ?array $uploadedFiles;


	protected ?ShRequest $serverTarget;


	/**
	 * @param array $server
	 * @return static
	 */
	public function withServerParams(array $server): static
	{
		$this->serverParams = $server;
		return $this;
	}

	/**
	 * @param ShRequest $server
	 * @return static
	 */
	public function withServerTarget(ShRequest $server): static
	{
		$this->serverTarget = $server;
		return $this;
	}
	
	
	/**
	 * @return ShRequest|null
	 */
	public function getServerTarget(): ?ShRequest
	{
		return $this->serverTarget;
	}
	

	/**
	 * @return null|array
	 */
	public function getServerParams(): ?array
	{
		return $this->serverParams;
	}


	/**
	 * @return array|null
	 */
	public function getQueryParams(): ?array
	{
		return $this->queryParams;
	}


	/**
	 * @param null|array $query
	 * @return ServerRequestInterface
	 */
	public function withQueryParams(?array $query): ServerRequestInterface
	{
		$this->queryParams = $query;
		return $this;
	}


	/**
	 * @return array|null
	 */
	public function getUploadedFiles(): ?array
	{
		return $this->uploadedFiles;
	}


	/**
	 * @param array|null $uploadedFiles
	 * @return ServerRequestInterface
	 */
	public function withUploadedFiles(?array $uploadedFiles): ServerRequestInterface
	{
		$this->uploadedFiles = $uploadedFiles;
		return $this;
	}


	/**
	 * @return array|object|null
	 */
	public function getParsedBody(): object|array|null
	{
		if (empty($this->parsedBody)) {
			$callback = Context::get(self::PARSE_BODY);

			$this->parsedBody = $callback($this->getBody());
		}
		return $this->parsedBody;
	}


	/**
	 * @param array|object|null $data
	 * @return ServerRequestInterface
	 */
	public function withParsedBody($data): ServerRequestInterface
	{
		$functions = function (StreamInterface $stream) use ($data) {
			$content = Parse::data($stream->getContents());
			if (!empty($content)) {
				return $content;
			}
			return $data;
		};
		Context::set(self::PARSE_BODY, $functions);
		return $this;
	}


	/**
	 * @return array
	 */
	public function getAttributes(): array
	{
		throw new \BadMethodCallException('Not Accomplish Method.');
	}


	/**
	 * @param string $name
	 * @param null $default
	 * @return mixed
	 */
	public function getAttribute($name, $default = null): mixed
	{
		throw new \BadMethodCallException('Not Accomplish Method.');
	}


	/**
	 * @param string $name
	 * @param mixed $value
	 * @return ServerRequestInterface
	 */
	public function withAttribute($name, $value): ServerRequestInterface
	{
		throw new \BadMethodCallException('Not Accomplish Method.');
	}


	/**
	 * @param string $name
	 * @return ServerRequestInterface
	 */
	public function withoutAttribute($name): ServerRequestInterface
	{
		throw new \BadMethodCallException('Not Accomplish Method.');
	}
}
