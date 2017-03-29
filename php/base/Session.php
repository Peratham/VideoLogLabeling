<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app;

/**
 * Description of Session
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class Session extends Component implements \ArrayAccess {
    
    private $_cookieParams = [];
    
    protected function init() {
        if(!$this->isActive()) {
            $this->start();
        }
    }
    
    public function isActive() {
        return session_status() === PHP_SESSION_ACTIVE;
    }
    
    public function getCookieParams()
    {
        return array_merge(session_get_cookie_params(), array_change_key_case($this->_cookieParams));
    }
    
    public function setCookieParams(array $value)
    {
        $this->_cookieParams = $value;
    }
    
    private function setCookieParamsInternal() {
        $data = $this->getCookieParams();
        if (isset($data['lifetime'], $data['path'], $data['domain'], $data['secure'], $data['httponly'])) {
            session_set_cookie_params($data['lifetime'], $data['path'], $data['domain'], $data['secure'], $data['httponly']);
        }
    }
    
    public function start() {
        if($this->isActive()) {
            return;
        }
        $this->setCookieParamsInternal();
        @session_start();
        
        // TODO: throw/log error?!
    }
    
    public function getId() {
        return session_id();
    }
    
    public function get($key, $default = NULL) {
        $this->start();
        return isset($_SESSION[$key]) ? $_SESSION[$key] : $default;
    }
    
    public function set($key, $value) {
        $this->start();
        $_SESSION[$key] = $value;
    }
    
    public function remove($key) {
        $this->start();
        if(isset($_SESSION[$key])) {
            $value = $_SESSION[$key];
            unset($_SESSION[$key]);
            return $value;
        }
        return NULL;
    }
    
    public function has($key) {
        $this->start();
        return isset($_SESSION[$key]);
    }

    public function offsetExists($offset) {
        return $this->has($offset);
    }

    public function offsetGet($offset) {
        return $this->get($offset);
    }

    public function offsetSet($offset, $value) {
        $this->set($offset, $value);
    }

    public function offsetUnset($offset) {
        $this->remove($offset);
    }

}
