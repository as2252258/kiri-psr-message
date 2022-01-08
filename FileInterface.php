<?php

namespace Http;

use Psr\Http\Message\UploadedFileInterface;

interface FileInterface extends UploadedFileInterface
{


	public function rename();



	public function getTmpPath();


}
