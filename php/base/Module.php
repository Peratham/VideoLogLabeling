<?php
namespace app;

include_once 'Component.php';

/**
 * Description of Module
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
abstract class Module extends Component
{
    /** @var String */
    public static $basePath;
    /** @var String */
    public static $controllerDir = 'controller';
    /** @var String */
    public static $modelDir = 'model';
    /** @var String */
    public static $viewDir = 'view';
    
    /** @var String */
    public $defaultController = 'default';
    /** @var String */
    public $defaultAction = 'index';
    
    /** @var Controller */
    public $activeController;
    /** @var String */
    public $defaultLayoutFile = 'layout.php';

    private $_view;
    
    /**
     * Gets called from the parent module.
     */
    abstract public function run();


    /**
     * 
     * @param String $path
     */
    public function setBasePath($path) {
        self::$basePath = $path;
    }
    
    /**
     * 
     * @return String
     */
    public function getBasePath() {
        return self::$basePath;
    }

    /**
     * 
     * @param String $path
     */
    public function setControllerDir($path) {
        self::$controllerDir = $path;
    }
    
    /**
     * 
     * @return String
     */
    public function getControllerDir() {
        return self::$controllerDir;
    }

    /**
     * 
     * @param String $path
     */
    public function setModelDir($path) {
        self::$modelDir = $path;
    }
    
    /**
     * 
     * @return String
     */
    public function getModelDir() {
        return self::$modelDir;
    }

    /**
     * 
     * @param String $path
     */
    public function setViewDir($path) {
        self::$viewDir = $path;
    }
    
    /**
     * 
     * @return String
     */
    public function getViewDir() {
        return self::$viewDir;
    }
    
    public function getView() {
        if($this->_view === NULL) {
            $this->_view = new View($this);
        }
        return $this->_view;
    }
    

    /**
     * 
     * @param String $name of the controller
     * @return Controller
     * @throws NotFoundHttpException
     */
    public function getController($name) {
        // set default controller if name is empty
        if($name === '' || $name === NULL) {
            $name = $this->defaultController;
        }
        
        // TODO: is this the correct logic?!?
        if($this->activeController === NULL) {
            if(class_exists($name)) {
                $this->activeController = new $name($this);
            } else {
                throw new NotFoundHttpException('Couldn\'t find controller class!');
            }
        }
        return $this->activeController;
    }

    /**
     * Tries to create a Module of the given $name.
     * The name could contain multiple submodules.
     * @param String $name
     * @return Module
     */
    public function getModule($name) {
        if (($pos = strpos($name, '/')) !== FALSE) {
            // sub-module
            $module = $this->getModule(substr($name, 0, $pos));

            return $module === null ? null : $module->getModule(substr($name, $pos + 1));
        }
        // TODO: try to create Sub-Module ...
        return NULL;
    }
    
    
}