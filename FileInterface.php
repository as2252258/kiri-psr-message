<?php

namespace Kiri\Message;

use Psr\Http\Message\UploadedFileInterface;

interface FileInterface extends UploadedFileInterface
{


	public function rename();



	public function getTmpPath();


}
