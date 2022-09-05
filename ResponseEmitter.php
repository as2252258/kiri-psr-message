<?php

namespace Kiri\Message;

use Kiri\Annotation\Inject;
use Kiri\Message\Constrict\OnDownloadInterface;
use Kiri\Message\Constrict\ResponseInterface;
use Kiri\Message\Constrict\RequestInterface;
use Kiri\Message\Response;

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
		if (is_array($emitter->getHeaders())) {
			foreach ($emitter->getHeaders() as $name => $values) {
				$response->header($name, implode(';', $values));
			}
		}
		if (is_array($emitter->getCookieParams())) {
			foreach ($emitter->getCookieParams() as $name => $cookie) {
				if (!is_array($cookie)) {
					var_dump($cookie);
					continue;
				}
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
