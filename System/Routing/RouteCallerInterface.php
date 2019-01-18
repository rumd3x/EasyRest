<?php

namespace EasyRest\System\Routing;

use Tightenco\Collect\Support\Collection;

interface RouteCallerInterface
{
    public function __construct(Route $route, Collection $request);
    public function call();
}
