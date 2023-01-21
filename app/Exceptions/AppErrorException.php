<?php

namespace App\Exceptions;

class AppErrorException extends \RuntimeException
{
	const HTTP_STATUS_CODE = 422;
}
