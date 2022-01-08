<?php

namespace Http;

use Http\Constrict\ResponseInterface;

interface Emitter
{


	/**
	 * @param mixed $response
	 * @param ResponseInterface $emitter
	 * @return mixed
	 */
	public function sender(mixed $response, ResponseInterface $emitter): void;

}
