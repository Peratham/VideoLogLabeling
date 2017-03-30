<?php
namespace app;

/**
 * Description of Model
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
abstract class Model extends Component
{
    protected $_errors = [];

    public function getName() {
        $reflector = new \ReflectionClass($this);
        return $reflector->getShortName();
    }
        
    public function attributes() {
        $class = new \ReflectionClass($this);
        $names = [];
        foreach ($class->getProperties(\ReflectionProperty::IS_PUBLIC) as $property) {
            if (!$property->isStatic()) {
                $names[] = $property->getName();
            }
        }
        return $names;
    }
    
    public function setAttributes($values) {
        if (is_array($values)) {
            $attributes = array_flip($this->attributes());
            foreach ($values as $name => $value) {
                if (isset($attributes[$name])) {
                    $this->$name = $value;
                }
            }
        }
    }
    
    public function load($data) {
        if (is_array($data)) {
            $this->setAttributes($data);
            return TRUE;
        }
        return FALSE;
    }
    
    public function addError($attribute, $message) {
        if(!isset($this->_errors[$attribute])) {
            $this->_errors[$attribute] = [];
        }
        $this->_errors[$attribute][] = $message;
    }
    
    public function hasError($attribute) {
        return isset($this->_errors[$attribute]) && !empty($this->_errors[$attribute]);
    }
    
    public function getErrors($attribute = NULL) {
        if ($attribute === null) {
            return $this->_errors === null ? [] : $this->_errors;
        }
        return isset($this->_errors[$attribute]) ? $this->_errors[$attribute] : [];
    }
    
    public function clearErrors($attribute = NULL) {
        if($attribute === NULL) {
            $this->_errors = [];
        } else {
            unset($this->_errors[$attribute]);
        }
    }
    
    abstract public function validate();
    
    abstract public function save();
}
