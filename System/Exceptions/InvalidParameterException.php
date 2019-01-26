<?php
namespace EasyRest\System\Exceptions;

use Exception;
use Throwable;

class InvalidParameterException extends Exception
{
    public function __construct(string $param, string $expected, string $given = null)
    {
        header('HTTP/1.0 400 Bad Request', true, 400);
        $finalMessage = sprintf('Parameter "%s" is not valid. Expected %s.', $param, $expected, $given ?: " $given given.");
        parent::__construct($finalMessage, 0, null);
    }
}
