<?php

namespace Http\Constrict;


use JetBrains\PhpStorm\Pure;
use Http\Message\Response;

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
	 * @return string|null
	 */
	public function getContentType(): ?string;


	/**
	 * @return bool
	 */
	public function hasContentType(): bool;


	/**
	 * @param string $type
	 * @return ResponseInterface
	 */
	public function withContentType(string $type): ResponseInterface;


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
