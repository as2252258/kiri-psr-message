<?php

namespace Kiri\Message\Constrict;


use Kiri\Message\ContentType;
use Kiri\Message\Response;
use JetBrains\PhpStorm\Pure;

/**
 * @mixin Response
 */
interface ResponseInterface extends \Psr\Http\Message\ResponseInterface
{


	/**
	 * @param string $path
	 * @return OnDownloadInterface
	 */
	public function file(string $path): OnDownloadInterface;


	/**
	 * @param $data
	 * @return ResponseInterface
	 */
	public function xml($data): ResponseInterface;


	/**
	 * @param $data
	 * @return ResponseInterface
	 */
	public function html($data): ResponseInterface;


	/**
	 * @param $data
	 * @return ResponseInterface
	 */
	public function json($data): ResponseInterface;


	/**
	 * @param int $code
	 * @param mixed $message
	 * @param mixed $data
	 * @param mixed $count
	 * @return ResponseInterface
	 */
	public function send(int $code, mixed $message = '', mixed $data = [], mixed $count = 0): ResponseInterface;


	/**
	 * @param int $code
	 * @param mixed $message
	 * @param mixed $data
	 * @param mixed $count
	 * @return ResponseInterface
	 */
	public function jsonTo(int $code, mixed $message = '', mixed $data = [], mixed $count = 0): ResponseInterface;


	/**
	 * @param array $data
	 * @param int $count
	 * @param string $message
	 * @return ResponseInterface
	 */
	public function data(array $data, int $count = 0, string $message = 'ok'): ResponseInterface;


	/**
	 * @param int $code
	 * @param string $message
	 * @return ResponseInterface
	 */
	public function failure(int $code, string $message = 'ok'): ResponseInterface;


	/**
	 * @param string $message
	 * @return ResponseInterface
	 */
	public function msg(string $message = 'ok'): ResponseInterface;

	/**
	 * @return string|null
	 */
	public function getContentType(): ?string;


	/**
	 * @return bool
	 */
	public function hasContentType(): bool;


	/**
	 * @param string $path
	 * @param string|null $domain
	 * @param int $statusCode
	 * @return mixed
	 */
	public function redirect(string $path, string $domain = null, int $statusCode = 302): static;


	/**
	 * @param ContentType $type
	 * @return ResponseInterface
	 */
	public function withContentType(ContentType $type): ResponseInterface;


	/**
	 * @param ?string $value
	 * @return ResponseInterface
	 */
	public function withAccessControlAllowOrigin(?string $value): ResponseInterface;


	/**
	 * @param ?string $value
	 * @return ResponseInterface
	 */
	public function withAccessControlRequestMethod(?string $value): ResponseInterface;


	/**
	 * @param ?string $value
	 * @return ResponseInterface
	 */
	public function withAccessControlAllowHeaders(?string $value): ResponseInterface;


	/**
	 * @return string|null
	 */
	#[Pure] public function getAccessControlAllowOrigin(): ?string;


	/**
	 * @return string|null
	 */
	#[Pure] public function getAccessControlAllowHeaders(): ?string;


	/**
	 * @return string|null
	 */
	#[Pure] public function getAccessControlRequestMethod(): ?string;


}
