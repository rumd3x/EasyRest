<?php

namespace EasyRest\System\Routing;

use ReflectionFunction;

class ClosureCaller extends RouteCaller implements RouteCallerInterface
{
    public function call()
    {
        $reflection = new ReflectionFunction($this->route->getAction());
        $parameters = collect($reflection->getParameters());
        return call_user_func_array($this->route->getAction(), $this->sortValues($parameters, $this->values)->all());
    }
}
