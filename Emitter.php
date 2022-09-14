<?php

namespace Kiri\Message;

use Kiri\Message\Constrict\ResponseInterface;

interface Emitter
{
	
	
	/**
	 * @param mixed $response
	 * @param ResponseInterface $emitter
	 * @return void
	 */
	public function sender(mixed $response, ResponseInterface $emitter): void;

}
