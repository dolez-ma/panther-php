<?php
/**
 * @Author dolez-ma
 */

namespace PantherPHP\Panther\App;


use PantherPHP\Panther\Traits\ClassMetaData;

class Session
{
    use ClassMetaData;

    public function start($name = 'panther'){
        if($name){
            session_name($name);
        }
        session_start();
    }


}