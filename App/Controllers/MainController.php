<?php
namespace EasyRest\App\Controllers;

use EasyRest\System\Response\JsonResponse;
use EasyRest\System\Controller;
use EasyRest\System\Response\HtmlResponse;

class MainController extends Controller
{
    public function index()
    {
        (new JsonResponse(['hello' => 'world']))->pretty();
    }

    public function home()
    {
        // (new HtmlResponse('test'));
        (new HtmlResponse('script'))->withData(['teste' => 'aaaaa']);
    }
}
