<?php
/**
 * Application
 *
 * @Author dolez-ma
 */

namespace PantherPHP\Panther;

class Application {

    protected $router;

    public function __construct()
    {
        $this->setRouter(new Router());
    }

    /**
     * @return mixed
     */
    public function getRouter()
    {
        return $this->router;
    }

    /**
     * @param mixed $router
     * @return Application
     */
    public function setRouter($router)
    {
        $this->router = $router;
        return $this;
    }

    public function run(){
        return $this->getRouter()->match();
    }

}