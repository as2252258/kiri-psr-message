<?php

namespace Kiri\Message;

use Exception;
use Kiri\Annotation\Inject;
use Kiri\Message\Constrict\ResponseInterface;
use Kiri\Message\Constrict\RequestInterface;

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
	 * @throws Exception
	 */
	public function sender(mixed $response, ResponseInterface|Response $emitter): void
	{
		foreach ($emitter->getHeaders() as $name => $values) {
			$response->header($name, implode(';', $values));
		}
//		foreach ($emitter->getCookieParams() as $name => $cookie) {
//			if (!is_array($cookie)) {
//				continue;
//			}
//			$response->cookie($name, ...$cookie);
//		}
		$response->setStatusCode($emitter->getStatusCode());
		$response->header('Server', 'swoole');
		$response->header('Swoole-Version', swoole_version());
		$response->end($emitter->getBody()->getContents());
	}
}
