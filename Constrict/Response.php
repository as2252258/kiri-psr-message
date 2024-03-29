<?php


namespace Kiri\Message\Constrict;


use JetBrains\PhpStorm\Pure;
use Kiri;
use Kiri\Abstracts\Config;
use Kiri\Di\Context;
use Kiri\Exception\ConfigException;
use Kiri\Message\ContentType;
use Kiri\Message\Response as Psr7Response;
use Kiri\Message\ServerRequest as RequestMessage;
use Kiri\Server\Server;
use Psr\Http\Message\StreamInterface;


/**
 * Class Response
 * @package Server
 */
class Response implements ResponseInterface
{

	const JSON = 'json';


	/**
	 * @throws ConfigException
	 */
	public function __construct()
	{
		$contentType = Config::get('response', ['format'  => ContentType::JSON]);
		$this->withContentType($contentType['format'] ?? ContentType::JSON);
	}


	/**
	 * @param $name
	 * @param $args
	 * @return mixed
	 */
	public function __call($name, $args)
	{
		if (!method_exists($this, $name)) {
			return $this->__call__()->{$name}(...$args);
		}
		return $this->{$name}(...$args);
	}


	/**
	 * @return array|null
	 */
	public function getCookieParams(): ?array
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @return array
	 */
	public function getHeaderArray(): array
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @param string $name
	 * @return mixed
	 */
	public function __get(string $name)
	{
		return $this->__call__()->{$name};
	}


	/**
	 * @return Psr7Response
	 */
	public function __call__(): Psr7Response
	{
		return Context::get(ResponseInterface::class, new Psr7Response());
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
	 * @return ResponseInterface|Psr7Response
	 */
	public function withProtocolVersion($version): ResponseInterface|Psr7Response
	{
		return $this->__call__()->{__FUNCTION__}($version);
	}


	/**
	 * @return array
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
	 * @return string
	 */
	public function getHeader($name): string
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
	 * @return ResponseInterface|Psr7Response
	 */
	public function withHeader($name, $value): ResponseInterface|Psr7Response
	{
		return $this->__call__()->{__FUNCTION__}($name, $value);
	}


	/**
	 * @param string $name
	 * @param string|string[] $value
	 * @return ResponseInterface|Psr7Response
	 */
	public function withAddedHeader($name, $value): ResponseInterface|Psr7Response
	{
		return $this->__call__()->{__FUNCTION__}($name, $value);
	}


	/**
	 * @param string $name
	 * @return ResponseInterface|Psr7Response
	 */
	public function withoutHeader($name): ResponseInterface|Psr7Response
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
	 * @return ResponseInterface|Psr7Response
	 */
	public function withBody(StreamInterface $body): ResponseInterface|Psr7Response
	{
		return $this->__call__()->{__FUNCTION__}($body);
	}

	/**
	 * @return int
	 */
	public function getStatusCode(): int
	{
		return $this->__call__()->{__FUNCTION__}();
	}


	/**
	 * @param int $code
	 * @param string $reasonPhrase
	 * @return ResponseInterface|Psr7Response
	 */
	public function withStatus($code, $reasonPhrase = ''): ResponseInterface|Psr7Response
	{
		return $this->__call__()->{__FUNCTION__}($code, $reasonPhrase);
	}
	
	
	/**
	 * @param mixed $content
	 * @return ResponseInterface
	 */
	public function withContent(mixed $content): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($content);
	}


	/**
	 * @return string
	 */
	public function getReasonPhrase(): string
	{
		return $this->__call__()->{__FUNCTION__}();
	}

	/**
	 * @param string $path
	 * @return OnDownloadInterface
	 */
	public function file(string $path): OnDownloadInterface
	{
		return $this->__call__()->{__FUNCTION__}($path);
	}

	/**
	 * @param $responseData
	 * @return string|array|bool|int|null
	 */
	public function _toArray($responseData): string|array|null|bool|int
	{
		return $this->__call__()->{__FUNCTION__}($responseData);
	}

	/**
	 * @param $data
	 * @return ResponseInterface
	 */
	public function xml($data): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($data);
	}

	/**
	 * @param $data
	 * @return ResponseInterface
	 */
	public function html($data): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($data);
	}

	/**
	 * @param $data
	 * @return ResponseInterface
	 */
	public function json($data): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($data);
	}

	/**
	 * @return string
	 */
	public function getContentType(): string
	{
		return $this->__call__()->{__FUNCTION__}();
	}

	/**
	 * @return bool
	 */
	public function hasContentType(): bool
	{
		return $this->__call__()->{__FUNCTION__}();
	}


    /**
     * @param ContentType $type
     * @return ResponseInterface
     */
	public function withContentType(ContentType $type): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($type);
	}


	/**
	 * @param string|null $value
	 * @return ResponseInterface
	 */
	public function withAccessControlAllowOrigin(?string $value): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($value);
	}


	/**
	 * @param string|null $value
	 * @return ResponseInterface
	 */
	public function withAccessControlRequestMethod(?string $value): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($value);
	}


	/**
	 * @param string|null $value
	 * @return ResponseInterface
	 */
	public function withAccessControlAllowHeaders(?string $value): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($value);
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


	/**
	 * @return int
	 */
	public function getClientId(): int
	{
		if (!Context::exists('client.id.property')) {
			$request = Context::get(RequestInterface::class, new RequestMessage());
			return Context::set('client.id.property', $request->getClientId());
		}
		return (int)Context::get('client.id.property');
	}


	/**
	 * @param int $code
	 * @param mixed|string $message
	 * @param mixed|array $data
	 * @param mixed|int $count
	 * @return ResponseInterface
	 */
	public function send(int $code, mixed $message = '', mixed $data = [], mixed $count = 0): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($code, $message, $data, $count);
	}
	
	
	/**
	 * @param mixed|array $data
	 * @return ResponseInterface
	 */
	public function jsonTo(array $data = []): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($data);
	}


	/**
	 * @param array $data
	 * @param int $count
	 * @param string $message
	 * @return ResponseInterface
	 */
	public function data(array $data, int $count = 0, string $message = 'ok'): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($data, $count, $count);
	}


	/**
	 * @param int $code
	 * @param string $message
	 * @return ResponseInterface
	 */
	public function failure(int $code, string $message = 'ok'): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($code, $message);
	}


	/**
	 * @param string $message
	 * @return ResponseInterface
	 */
	public function msg(string $message = 'ok'): ResponseInterface
	{
		return $this->__call__()->{__FUNCTION__}($message);
	}


	/**
	 * @param string $path
	 * @param string|null $domain
	 * @param int $statusCode
	 * @return mixed
	 */
	public function redirect(string $path, string $domain = null, int $statusCode = 302): static
	{
		return $this->__call__()->{__FUNCTION__}($path, $domain, $statusCode);
	}
}
