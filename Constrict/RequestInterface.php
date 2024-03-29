<?php

namespace Kiri\Message\Constrict;


use Kiri\Message\FileInterface;
use Kiri\Message\Handler\AuthorizationInterface;
use Kiri\Message\ServerRequest;
use JetBrains\PhpStorm\Pure;

/**
 *
 * @mixin ServerRequest
 */
interface RequestInterface extends \Psr\Http\Message\RequestInterface
{
	
	
	public function getServerTarget(): \Swoole\Http\Request;


	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasQueryParams(string $name): bool;


	/**
	 * @param string $name
	 * @return bool
	 */
	public function hasPostParams(string $name): bool;


	/**
	 * @param string $method
	 * @return bool
	 */
	public function isMethod(string $method): bool;

	/**
	 * @param string $name
	 * @return FileInterface|null
	 */
	public function file(string $name): ?FileInterface;


	/**
	 * @return array
	 */
	public function getHeaderArray(): array;


	/**
	 * @return array
	 */
	public function all(): array;

	/**
	 * @param string $name
	 * @param int|string|bool|null $default
	 * @return mixed
	 */
	public function query(string $name, int|string|bool|null $default = null): mixed;

	/**
	 * @param string $name
	 * @param int|string|bool|array|null $default
	 * @return mixed
	 */
	public function post(string $name, int|string|bool|null|array $default = null): mixed;

	/**
	 * @param string $name
	 * @param bool $required
	 * @return int|null
	 */
	public function int(string $name, bool $required = false): ?int;

	/**
	 * @param string $name
	 * @param bool $required
	 * @return float|null
	 */
	public function float(string $name, bool $required = false): ?float;

	/**
	 * @param string $name
	 * @param bool $required
	 * @return string|null
	 */
	public function date(string $name, bool $required = false): ?string;

	/**
	 * @param string $name
	 * @param bool $required
	 * @return int|null
	 */
	public function timestamp(string $name, bool $required = false): ?int;

	/**
	 * @param string $name
	 * @param bool $required
	 * @return string|null
	 */
	public function string(string $name, bool $required = false): ?string;

	/**
	 * @param string $name
	 * @param array $default
	 * @return array|null
	 */
	public function array(string $name, array $default = []): ?array;

	/**
	 * @return array|null
	 */
	public function gets(): ?array;

	/**
	 * @param string $field
	 * @param string $sizeField
	 * @param int $max
	 * @return float|int
	 */
	public function offset(string $field = 'page', string $sizeField = 'size', int $max = 100): float|int;

	/**
	 * @param string $field
	 * @param int $max
	 * @return int
	 */
	public function size(string $field = 'size', int $max = 100): int;


	/**
	 * @param $name
	 * @param null $default
	 * @return mixed
	 */
	public function input($name, $default = null): mixed;

	/**
	 * @return float
	 */
	#[Pure] public function getStartTime(): float;

	/**
	 * @param AuthorizationInterface $authority
	 */
	public function setAuthority(AuthorizationInterface $authority): void;

	/**
	 * @return int
	 */
	public function getClientId(): int;


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
