<?php
/**
 * @Author dolez-ma
 */
namespace PantherPHP\Panther\Traits;

trait ValuesTrait {

    /**
     * returns a value from the parent entity
     */
    public function getValue($name){
        $values = $this->getResource();

        if(isset($values[$name])){
            return $values[$name];
        }
        return false;
    }

    public function setValue($name, $value){
        $values = $this->getResource();
        $values[$name] = $value;
        $this->setResource($values);
        return $this;
    }

    public function getValues(){
        return $this->getResource();
    }

    public function setValues($values){
        $this->setResource($values);
        return $this;
    }

    protected function getResource(){
        switch($this->getClassName()){
            case 'Post':
                return $_POST;
            case 'Get':
                return $_GET;
            case 'Session':
                return $_SESSION;
            case 'Parameter':
                return $this->params;
        }
        return $this;
    }

    protected function setResource($values){
        switch($this->getClassName()){
            case 'Post':
                $_POST = $values;
                break;
            case 'Get':
                $_GET = $values;
                break;
            case 'Session':
                $_SESSION = $values;
                break;
            case 'Parameter':
                $this->params = $values;
                break;
        }
        return $this;
    }

}