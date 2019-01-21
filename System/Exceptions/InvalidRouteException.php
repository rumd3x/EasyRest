<?php
namespace EasyRest\System\Exceptions;

use Exception;
use Throwable;

class InvalidRouteException extends Exception
{
    /**
     * @var string
     */
    public $routeFile;

    public function __construct(string $routeFile, Throwable $previous = null)
    {
        $this->routeFile = $routeFile;
        $finalMessage = sprintf('Error adding route to router. Route File "%s" at line %d: %s', $this->routeFile, $previous->getLine(), $previous->getMessage());
        parent::__construct($finalMessage, $previous->getCode(), $previous);
    }
}
