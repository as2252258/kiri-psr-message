<?php

namespace Kiri\Message;

class Cookie
{


	/**
	 * @param string $name
	 * @param mixed $value
	 * @param mixed $expires
	 * @param string $path
	 * @param string|null $domain
	 * @param string|null $secure
	 * @param string|null $httponly
	 * @param string|null $samesite
	 * @param string|null $priority
	 */
	public function __construct(
		public string  $name,
		public mixed   $value,
		public mixed   $expires = null,
		public string  $path = '/',
		public ?string $domain = null,
		public ?string $secure = null,
		public ?string $httponly = null,
		public ?string $samesite = null,
		public ?string $priority = null
	)
	{
	}

}
