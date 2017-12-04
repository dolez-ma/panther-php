<?php
/**
 * @Author dolez-ma
 */
namespace PantherPHP\Panther\Traits;

trait ClassMetaData {

    /**
     * Returns the classname minus the namespace
     */
    public function getClassName(){
        return array_pop(explode('\\', get_class($this)));
    }

    /**
     * Returns the namespace
     */
    public function getNamespace(){
        $namespace = explode('\\', get_class($this));
        array_pop($namespace);
        return implode('\\', $namespace);
    }

}