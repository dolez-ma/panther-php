<?php
/**
 * Application
 *
 * @Author dolez-ma
 */

namespace PantherPHP\Panther;

use PantherPHP\Panther\App\Brain;
use PantherPHP\Panther\App\CommandLine;
use PantherPHP\Panther\App\Configuration;
use PantherPHP\Panther\App\Get;
use PantherPHP\Panther\App\Hook;
use PantherPHP\Panther\App\Log;
use PantherPHP\Panther\App\Messages;
use PantherPHP\Panther\App\Post;
use PantherPHP\Panther\App\Session;

class Beast {

    /**
     * @var string $baseFolder
     */
    static $baseFolder = null;

    /**
     * @var string $publicUrl
     */
    static $publicUrl = null;

    /**
     * @var string $debug
     */
    static $debug = null;

    /**
     * @var CommandLine $commandLine
     */
    static $commandLine = null;

    /**
     * @var Configuration $configuration
     */
    static $configuration = null;

    /**
     * @var Post $post
     */
    static $post = null;

    /**
     * @var Get $get
     */
    static $get = null;

    /**
     * @var Session $session
     */
    static $session = null;

    /**
     * @var $hook Hook
     */
    static $hook = null;

    /**
     * @var $log Log
     */
    static $log = null;

    /**
     * @var $messages Messages
     */
    static $messages = null;

    /**
     * @var $brain Brain the router
     */
    static $brain = null;

    /**
     * @var $routes array
     */
    static $routes = array();

    public static function wakeUp(){
        // if $debug = 1, activate debug, else deactivate
        if(isset($_GET['debug']) && $_GET['debug'] == 1){
            self::debugOn();
        } else {
            self::debugOff();
        }

        // load the configuration
        self::getConfiguration()->load();

        // Start the session management
        self::getSession()->start();
    }

    /**
     * Activate debug mode, to display errors
     */
    public static function debugOn(){
        self::$debug = true;
        ini_set('display_errors', '1');
    }

    public static function debugOff(){
        self::$debug = false;
        ini_set('display_errors', '0');
    }

    /**
     * Returns the folder requested
     * @param string $path
     * @return string
     */
    public static function getFolder($path = null){
        $folder = self::getBaseFolder();
        if($path){
            $folder = rtrim($folder, DS) . DS . trim($path, DS);
        }
        return $folder;
    }

    /**
     * returns the base folder of the app
     * @return string
     */
    public static function getBaseFolder(){
        if(!self::$baseFolder){
            $baseFolder = rtrim(getcwd(), DS);
            self::$baseFolder = rtrim($baseFolder, 'public');
        }
        return self::$baseFolder;
    }

    /**
     * @return CommandLine
     */
    public static function getCommandLine()
    {
        if(!self::$commandLine){
            self::$commandLine = new CommandLine();
        }
        return self::$commandLine;
    }

    /**
     * @return Configuration
     */
    public static function getConfiguration()
    {
        if(!self::$configuration){
            self::$configuration = new Configuration();
        }
        return self::$configuration;
    }

    /**
     * @return Hook
     */
    public static function getHook()
    {
        if(!self::$hook){
            self::$hook = new Hook();
        }
        return self::$hook;
    }

    /**
     * @return Log
     */
    public static function getLog()
    {
        if(!self::$log){
            self::$log = new Log();
        }
        return self::$log;
    }

    /**
     * @return Messages
     */
    public static function getMessages()
    {
        if(!self::$messages){
            self::$messages = new Messages();
        }
        return self::$messages;
    }

    /**
     * @return Session
     */
    public static function getSession()
    {
        if(!self::$session){
            self::$session = new Session();
        }
        return self::$session;
    }

    /**
     * @return Post
     */
    public static function getPost()
    {
        if(!self::$post){
            self::$post = new Post();
        }
        return self::$post;
    }

    /**
     * @return Get
     */
    public static function getGet()
    {
        if(!self::$get){
            self::$get = new Get();
        }
        return self::$get;
    }

    /**
     * @return Brain
     */
    public static function getBrain()
    {
        if(!self::$brain){
            self::$brain = new Brain();
            self::$brain->collectRoutes();
        }
        return self::$brain;
    }


}