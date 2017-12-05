<?php


use PantherPHP\Panther\Beast as Panther;
use PantherPHP\Panther\Controller;

class Home extends Controller
{
    public function index(){}

    public function toto(){
        echo 'toto@home';
    }

    public function viewPost(){
        echo 'View post:' . Panther::getParameter()->getValue('id');
        var_dump(Panther::getParameter()->getValues());
    }

    public function viewPostDetails(){
        echo 'Detail of post' . Panther::getParameter()->getValue('name');
        var_dump(Panther::getParameter()->getValues());
    }
}