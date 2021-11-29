<?php

namespace Http;

use Annotation\Inject;
use Http\Constrict\OnDownloadInterface;
use Http\Constrict\ResponseInterface;
use Http\Constrict\RequestInterface;
use Http\Message\Response;

/**
 *
 */
class ResponseEmitter implements Emitter
{


	/**
	 * @var RequestInterface
	 */
	#[Inject(RequestInterface::class)]
	public RequestInterface $request;


	/**
	 * @param \Swoole\Http\Response $response
	 * @param Response|ResponseInterface $emitter
	 * @throws \Exception
	 */
	public function sender(mixed $response, ResponseInterface|Response $emitter): void
	{
		var_dump($emitter->getHeaders());
		if (is_array($emitter->getHeaders())) {
			foreach ($emitter->getHeaders() as $name => $values) {
				$response->header($name, implode(';', $values));
			}
		}
		if (is_array($emitter->getCookieParams())) {
			foreach ($emitter->getCookieParams() as $name => $cookie) {
				$response->cookie($name, ...$cookie);
			}
		}
		$response->setStatusCode($emitter->getStatusCode());
		$response->header('Server', 'swoole');
		$response->header('Swoole-Version', swoole_version());
		if (!($emitter instanceof OnDownloadInterface)) {
			$response->end($emitter->getBody()->getContents());
		} else {
			$emitter->dispatch($response);
		}
	}

}
