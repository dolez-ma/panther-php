<?php

namespace PantherPHP\Panther\App;


use PantherPHP\Panther\Traits\ClassMetaData;
use PantherPHP\Panther\Traits\ValuesTrait;

class Parameter
{

    use ClassMetaData;
    use ValuesTrait;

    protected $params = array();

}