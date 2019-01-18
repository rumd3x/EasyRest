<?php
namespace EasyRest\System\Routing;

use Closure;
use EasyRest\System\Request;
use EasyRest\System\Routing\Route;
use Tightenco\Collect\Support\Collection;
use EasyRest\System\Exceptions\RouteNotFoundException;

final class Router
{
    use RoutingUtils;
    /**
     * @var Collection
     */
    public $routes;

    public function __construct()
    {
        $this->routes = collect([]);
    }

    /**
     * @param Route $route
     * @return void
     */
    public function addRoute(Route $route)
    {
        $this->routes->push($route);
        return $this;
    }

    /**
     * @param Request $request
     * @return void
     */
    public function handle(Request $request)
    {
        $this->sortRoutes();

        $match = false;
        foreach ($this->routes as $route) {
            $match = $this->evalRequest($request, $route);
            if ($match) {
                break;
            }
        }

        if (!$match) {
            throw new RouteNotFoundException($request);
        }

        $params = $this->makeRequestParams($request, $route);
        if ($route->getAction() instanceof Closure) {
            return (new ClosureCaller($route, $params))->call();
        }

        return (new ControllerCaller($route, $params))->call();
    }

    /**
     * Puts routes in the correct order for evaluating them
     *
     * @return void
     */
    private function sortRoutes()
    {
        $this->routes = $this->routes->unique(function ($route) {
            return $route->getMethod().$route->getUri();
        });

        $this->routes = $this->routes->sortBy(function ($route) {
            return count(array_filter(explode('/', $route->getUri()))) * -1;
        });

        $this->routes = $this->routes->sortBy(function ($route) {
            $vars = array_filter(explode('/', $route->getUri()));
            $countVars = 0;
            for ($i=1; $i <= count($vars); $i++) {
                $isVar = $this->isStringRouteVar($vars[$i]);
                if ($isVar) {
                    $countVars++;
                }
            }
            return $countVars;
        });
    }

    /**
     * Tries to match a route to the request
     *
     * @param Request $request
     * @return bool
     */
    private function evalRequest(Request $request, Route $route)
    {
        if ($request->getMethod() !== $route->getMethod()) {
            return false;
        }

        $routeParams = array_filter(explode('/', $route->getUri()));
        if ($request->route->count() !== count($routeParams)) {
            return false;
        }

        $routeParams = array_values($routeParams);
        foreach ($request->route as $index => $param) {
            if (trim($param, '/') !== $routeParams[$index] && !$this->isStringRouteVar($routeParams[$index])) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param Request $request
     * @return Collection
     */
    private function makeRequestParams(Request $request, Route $route)
    {
        $result = collect([]);
        $routeParams = array_values(array_filter(explode('/', $route->getUri())));

        foreach ($request->route as $key => $value) {
            if ($this->isStringRouteVar($routeParams[$key])) {
                $result->put(trim($routeParams[$key], ':'), $value);
            }
        }

        return $result;
    }
}
