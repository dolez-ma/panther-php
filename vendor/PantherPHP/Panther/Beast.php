<?php
/**
 * Application
 *
 * @Author dolez-ma
 */

namespace PantherPHP\Panther;

class Beast {

    // Router
    protected $brain;

    public function __construct()
    {
        error_reporting(E_ALL);
        ini_set('display_errors', 1);

        $this->setBrain(new Brain());
    }

    /**
     * @return mixed
     */
    public function getBrain()
    {
        return $this->brain;
    }

    /**
     * @param $brain
     * @return Beast
     */
    public function setBrain($brain)
    {
        $this->brain = $brain;
        return $this;
    }

    public function wakeUp(){
        return $this->getBrain()->resolve();
    }

}