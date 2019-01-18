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

    /**
     * @var Collection
     */
    protected $values;

    public function __construct(Route $route, Collection $values)
    {
        $this->route = $route;
        $this->values = $values;
    }

    abstract public function call();
}
