<?php


use PantherPHP\Panther\Controller;

class Home extends Controller
{
    public function index(){
        echo 'index@home';
    }

    public function toto(){
        echo 'toto@home';
    }
}