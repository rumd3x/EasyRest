<?php

namespace EasyRest\System\Routing;

use Tightenco\Collect\Support\Collection;

abstract class RouteCaller
{
    use RoutingUtils;

    /**
     * @var Route
     */
    protected $route;

    public function __construct(Route $route)
    {
        $this->route = $route;
    }

    abstract public function call(Collection $values);
}
