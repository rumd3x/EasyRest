<?php
namespace EasyRest\System\Exceptions;

use Exception;
use Throwable;

class InvalidClassException extends Exception
{
    /**
     * @var string
     */
    public $className;

    /**
     * @var string
     */
    public $message;

    public function __construct(string $message, string $className, Throwable $previous = null)
    {
        $this->message = $message;
        $this->className = $className;
        $finalMessage = sprintf('Class "%s": %s', $this->className, $this->message);
        parent::__construct($finalMessage, $previous ? $previous->getCode() : 0, $previous);
    }
}
