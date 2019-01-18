<?php
namespace EasyRest\System\Routing;

use Closure;
use ReflectionMethod;
use ReflectionFunction;
use EasyRest\System\Core;
use EasyRest\System\Request;
use Tightenco\Collect\Support\Collection;
use EasyRest\System\Exceptions\InvalidRouteActionException;

final class Route
{
    const GET = "GET";
    const POST = "POST";
    const PUT = "PUT";
    const DELETE = "DELETE";

    /**
     * @var string
     */
    private $uri;

    /**
     * @var string
     */
    private $method;

    /**
     * @var mixed
     */
    private $action;

    /**
     * @SuppressWarnings(PHPMD.StaticAccess)
     *
     * @param string $method
     * @param string $uri
     * @param mixed $action
     * @param array $middlewares
     */
    public function __construct(string $method, string $uri, $action, array $middlewares = [])
    {
        $this->uri = '/'.trim($uri, '/');
        $this->method = $method;
        $this->action = $action;
        $this->middlewares = collect($middlewares);

        $injector = Core::getInjector();
        $router = $injector->inject('Routing\Router');
        $router->addRoute($this);
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUri()
    {
        return $this->uri;
    }

    public function getAction()
    {
        return $this->action;
    }
}
