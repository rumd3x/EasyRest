<?php

namespace EasyRest\System\Routing;

use Tightenco\Collect\Support\Collection;

interface RouteCallerInterface
{
    public function __construct(Route $route);
    public function call(Collection $values);
}
