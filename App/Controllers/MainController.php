<?php
namespace EasyRest\App\Controllers;

use EasyRest\System\Response\JsonResponse;
use EasyRest\System\Controller;

class MainController extends Controller
{
    public function index()
    {
        (new JsonResponse(['hello' => 'world']))->pretty();
    }

    public function home()
    {
        echo 'hi';
    }
}
