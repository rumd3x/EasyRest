<?php
namespace EasyRest\System;

final class Core
{
    /**
     * @var Environment
     */
    public $env;

    /**
     * @var TimeTracker
     */
    public $timeTracker;

    /**
     * @var Injector
     */
    public static $injector;

    /**
     * @var Request
     */
    public $request;

    /**
     * @var Router
     */
    public $router;

    /**
     * @var Kernel
     */
    public $kernel;

    public function __construct()
    {
        self::$injector = new Injector();
    }

    /**
     * Configures the application for running it
     *
     * @return self
     */
    public function prepare()
    {
        $this->timeTracker = $this->getInjector()->inject('TimeTracker');
        $this->env = $this->getInjector()->inject('Environment');
        $this->env->parseFile(__DIR__.'/../environment.json');
        $this->toggleShowErrors();
        return $this;
    }

    /**
     * @return void
     */
    private function toggleShowErrors()
    {
        if ($this->env->get('server') !== 'production') {
            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
        }
    }

    /**
     * @return Injector
     */
    public static function getInjector()
    {
        return self::$injector;
    }

    /**
     * Runs the application
     *
     * @return void
     */
    public function start()
    {
        $this->kernel = $this->getInjector()->inject('Kernel');
        $this->router = $this->getInjector()->inject(__NAMESPACE__.'\Routing\Router');
        $this->request = $this->getInjector()->inject(__NAMESPACE__.'\Request');
        $this->router->handle($this->request);
    }
}
