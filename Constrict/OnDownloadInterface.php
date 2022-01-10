<?php

namespace Kiri\Message\Constrict;

use Swoole\Http\Response;

interface OnDownloadInterface
{

	public function dispatch(Response $response);

}
