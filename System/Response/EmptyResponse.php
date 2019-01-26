<?php
namespace EasyRest\System\Response;

use Tightenco\Collect\Support\Collection;

class EmptyResponse extends Response
{
    public function print()
    {
        header('Content-Type: text/html');
        return '';
    }
}
