<?php

namespace Kiri\Message;

use Exception;
use Kiri\Message\Constrict\OnDownloadInterface;
use Kiri\Message\Constrict\ResponseInterface;
use JetBrains\PhpStorm\Pure;
use Kiri\Core\Help;
use Kiri\Core\Json;
use Kiri;
use ReflectionException;

/**
 *
 */
class Response implements ResponseInterface
{
	
	
	use Message;
	
	
	const CONTENT_TYPE_HTML = 'text/html; charset=utf-8';
	
	
	protected string $charset = 'utf8';
	
	
	protected int $statusCode = 200;
	
	
	protected string $reasonPhrase = '';
	
	
	/**
	 * __construct
	 * @throws Exception
	 */
	public function __construct()
	{
		$this->stream = copy(Stream::class);
	}
	
	
	/**
	 * @return void
	 */
	public function __clone(): void
	{
		// TODO: Implement __clone() method.
		$this->stream = copy(Stream::class);
	}
	
	
	/**
	 * @return int
	 */
	public function getStatusCode(): int
	{
		return $this->statusCode;
	}
	
	
	/**
	 * @param int $code
	 * @param string $reasonPhrase
	 * @return $this|Response
	 */
	public function withStatus($code, $reasonPhrase = ''): static
	{
		$this->statusCode = $code;
		$this->reasonPhrase = $reasonPhrase;
		return $this;
	}
	
	
	/**
	 * @return string
	 */
	public function getReasonPhrase(): string
	{
		return $this->reasonPhrase;
	}
	
	
	/**
	 * @return string|null
	 */
	#[Pure] public function getAccessControlAllowOrigin(): ?string
	{
		return $this->getHeaderLine('Access-Control-Allow-Origin');
	}
	
	
	/**
	 * @return string|null
	 */
	#[Pure] public function getAccessControlAllowHeaders(): ?string
	{
		return $this->getHeaderLine('Access-Control-Allow-Headers');
	}
	
	
	/**
	 * @return string|null
	 */
	#[Pure] public function getAccessControlRequestMethod(): ?string
	{
		return $this->getHeaderLine('Access-Control-Request-Method');
	}
	
	
	/**
	 * @param ContentType $type
	 * @return Response
	 */
	public function withContentType(ContentType $type): static
	{
		return $this->withHeader('Content-Type', $type->toString());
	}
	
	
	/**
	 * @return bool
	 */
	#[Pure] public function hasContentType(): bool
	{
		return $this->hasHeader('Content-Type');
	}
	
	/**
	 * @param string|null $value
	 * @return Response
	 */
	public function withAccessControlAllowHeaders(?string $value): static
	{
		return $this->withHeader('Access-Control-Allow-Headers', $value);
	}
	
	
	/**
	 * @param string|null $value
	 * @return Response
	 */
	public function withAccessControlRequestMethod(?string $value): static
	{
		return $this->withHeader('Access-Control-Request-Method', $value);
	}
	
	
	/**
	 * @param string|null $value
	 * @return Response
	 */
	public function withAccessControlAllowOrigin(?string $value): static
	{
		return $this->withHeader('Access-Control-Allow-Origin', $value);
	}
	
	
	/**
	 * @param $data
	 * @param ContentType $contentType
	 * @return static
	 */
	public function json($data, ContentType $contentType = ContentType::JSON): static
	{
		$this->stream->write(json_encode($data));
		
		return $this->withContentType($contentType);
	}
	
	
	/**
	 * @param $data
	 * @param ContentType $contentType
	 * @return static
	 */
	public function html($data, ContentType $contentType = ContentType::HTML): static
	{
		if (!is_string($data)) {
			$data = json_encode($data, JSON_UNESCAPED_UNICODE);
		}
		
		$this->stream->write((string)$data);
		
		return $this->withContentType($contentType);
	}
	
	
	/**
	 * @param mixed $content
	 * @return static
	 */
	public function withContent(mixed $content): ResponseInterface
	{
		$this->stream->write($content);
		return $this;
	}
	
	
	/**
	 * @param $data
	 * @param ContentType $contentType
	 * @return static
	 */
	public function xml($data, ContentType $contentType = ContentType::XML): static
	{
		$this->stream->write(Help::toXml($data));
		
		return $this->withContentType($contentType);
	}
	
	
	/**
	 * @param $path
	 * @param bool $isChunk
	 * @param int $size
	 * @param int $offset
	 * @return OnDownloadInterface
	 * @throws Exception
	 */
	public function file($path, bool $isChunk = FALSE, int $size = -1, int $offset = 0): OnDownloadInterface
	{
		$path = realpath($path);
		if (!file_exists($path) || !is_readable($path)) {
			throw new Exception('Cannot read file "' . $path . '", no permission');
		}
		return (new OnDownload())->path($path, $isChunk, $size, $offset);
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
		if ($code == 0) {
			if (is_array($message)) {
				$data = $message;
				$message = '';
			}
			$this->stream->write(Json::jsonSuccess($data, $message, $count));
		} else {
			$this->stream->write(Json::jsonFail($message, $code, $data, $count));
		}
		return $this;
	}
	
	
	/**
	 * @param mixed|array $data
	 * @return ResponseInterface
	 */
	public function jsonTo(array $data): ResponseInterface
	{
		$this->stream->write(json_encode($data, JSON_UNESCAPED_UNICODE));
		return $this->withContentType(ContentType::JSON);
	}
	
	
	/**
	 * @param int $code
	 * @param mixed|string $message
	 * @param mixed|array $data
	 * @param mixed|int $count
	 * @param array $exPageInfo
	 * @return ResponseInterface
	 */
	private function _end(int $code, string $message = '', array $data = [], int $count = 0, array $exPageInfo = []): ResponseInterface
	{
		$this->stream->write(Json::encode([
			'code' => $code,
			'message' => $message,
			'count' => $count,
			'exPageInfo' => $exPageInfo,
			'param' => $data,
		]));
		return $this->withContentType(ContentType::JSON);
	}
	
	
	/**
	 * @param array $data
	 * @param int $count
	 * @param string $message
	 * @return ResponseInterface
	 */
	public function data(array $data, int $count = 0, string $message = 'ok'): ResponseInterface
	{
		return $this->_end(0, $message, $data, $count);
	}
	
	
	/**
	 * @param int $code
	 * @param string $message
	 * @return ResponseInterface
	 */
	public function failure(int $code, string $message = 'ok'): ResponseInterface
	{
		return $this->_end($code, $message, [], 0);
	}
	
	
	/**
	 * @param string $message
	 * @return ResponseInterface
	 */
	public function msg(string $message = 'ok'): ResponseInterface
	{
		return $this->_end(0, $message, [], 0);
	}
	
	
	/**
	 * @param string $path
	 * @param string|null $domain
	 * @param int $statusCode
	 * @return mixed
	 */
	public function redirect(string $path, string $domain = null, int $statusCode = 302): static
	{
		return $this->withStatus($statusCode)->withHeader('Localhost', $domain . $path);
	}
}
