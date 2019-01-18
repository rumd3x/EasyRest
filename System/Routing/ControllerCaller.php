<?php

namespace EasyRest\System\Routing;

use ReflectionMethod;
use EasyRest\System\Exceptions\InvalidRouteActionException;

class ControllerCaller extends RouteCaller implements RouteCallerInterface
{
    public function call()
    {
        if (!is_string($this->route->getAction())) {
            throw new InvalidRouteActionException('Not a valid string or closure defined as action', $this->route);
        }

        $actionArray = array_filter(explode('@', $this->route->getAction()));
        if (trim($this->route->getAction()) === '' || count($actionArray) !== 2) {
            throw new InvalidRouteActionException('Not a valid action string', $this->route);
        }

        $action = collect([
            'controller' => $actionArray[0],
            'method' => $actionArray[1],
        ]);

        if (!$controller = $this->getController($action->get('controller'))) {
            $message = sprintf('Could not find controller %s', $action->get('controller'));
            throw new InvalidRouteActionException($message, $this->route);
        }

        if (!method_exists($controller, $action->get('method'))) {
            $message = sprintf('Method %s not found on controller %s', $action->get('method'), $action->get('controller'));
            throw new InvalidRouteActionException($message, $this->route);
        }

        $reflection = new ReflectionMethod($controller, $action->get('method'));
        $parameters = collect($reflection->getParameters());
        return $reflection->invokeArgs($controller, $this->sortValues($parameters, $this->values)->all());
    }
}
