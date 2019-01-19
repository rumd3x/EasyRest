<?php
namespace EasyRest\System\Exceptions;

use Exception;
use EasyRest\System\Request;

class RouteNotFoundException extends Exception
{
    /**
     * @var string
     */
    public $request;

    public function __construct(Request $request)
    {
        header('HTTP/1.0 404 Not Found', true, 404);
        $this->request = $request;
        $finalMessage = sprintf('No route found for current url');
        parent::__construct($finalMessage, 404, null);
    }
}
