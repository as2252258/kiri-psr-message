<?php

namespace Kiri\Message\Constrict;

class Validator
{


	private bool $isSuccess;
	private string $message;


	/**
	 * @param bool $isSuccess
	 * @param string $message
	 */
	public function __construct(bool $isSuccess, string $message)
	{
		$this->isSuccess = $isSuccess;
		$this->message = $message;
	}


	/**
	 * @return bool
	 */
	public function success(): bool
	{
		return $this->isSuccess;
	}


	/**
	 * @return string
	 */
	public function error(): string
	{
		return $this->message;
	}

}
