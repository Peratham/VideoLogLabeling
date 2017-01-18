<?php
namespace app;

/**
 * Description of Cookie
 * Can be used via request and/or response:
 *  Application::$app->request->cookie['overview'];
 *  Application::$app->response->cookie['overview'] = 'my val';
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class Cookie implements \ArrayAccess
{
    /**
     * Array maintaining the individual cookie data.
     * Each item is indexed by its item name and the item value represents the cookie information like expiration time, ...
     * 
     * @var mixed[]
     */
    private $data = [];
    
    /**
     * Helper method to set the attribute of the named ($key) cookie.
     * 
     * @param string $key the name of the cookie item
     * @param string $attribute the attribute of the cookie item
     * @param mixed $value the value for the attribute
     * @return boolean return true if value was successfull set, false otherwise
     */
    private function setAttribute($key, $attribute, $value) {
        if(isset($this->data[$key])) {
            $this->data[$key][$attribute] = $value;
            return TRUE;
        }
        return FALSE;
    }
    
    /**
     * Return all the data currently registered to this cookie.
     * 
     * @return mixed[]
     */
    public function getData() {
        return $this->data;
    }
    
    /**
     * Sets the named ($key) cookie item and its attributes.
     * The attributes are used to set the parameter of the 'setcookie()' funciton. See http://php.net/manual/en/function.setcookie.php
     * 
     * @param string $key the name of the cookie item
     * @param mixed $value the value of the cookie item
     * @param int $expire the expiration time of the cookie item
     * @param string $path The path on the server in which the cookie will be available on
     * @param string $domain The (sub)domain that the cookie is available to.
     * @param boolean $secure Indicates that the cookie should only be transmitted over a secure HTTPS connection from the client.
     * @param boolean $httpOnly When TRUE the cookie will be made accessible only through the HTTP protocol.
     */
    public function setValue($key, $value, $expire = 0, $path = '/', $domain = '', $secure = FALSE, $httpOnly = TRUE) {
        $this->data[$key] = ['value'=>$value, 'expire'=>$expire, 'path'=>$path, 'domain'=>$domain, 'secure'=>$secure, 'httpOnly'=>$httpOnly];
    }
    
    /**
     * Replaces an already set value of the named cookie.
     * 
     * @param string $key the name of the cookie item
     * @param mixed $value the value for the attribute
     * @return boolean return true if value was successfull set, false otherwise
     */
    public function replaceValue($key, $value) {
        return $this->setAttribute($key, 'value', $value);
    }
    
    /**
     * Returns the value of the named cookie.
     * 
     * @param string $key the name of the cookie item
     * @param mixed $default the default value, which should be returned if the named cookie item doen't exists
     * @return mixed the value of the cookie item.
     */
    public function getValue($key, $default=NULL) {
        return isset($this->data[$key])?$this->data[$key]['value']:$default;
    }
    
    /**
     * Returns the full cookie item definition.
     * 
     * @param string $key the name of the cookie item
     * @return mixed[] cookie item definition
     */
    public function getFullValue($key) {
        return isset($this->data[$key])?$this->data[$key]:[];
    }
    
    /**
     * The time the cookie item expires.
     * This is a Unix timestamp so is in number of seconds since the epoch. In other 
     * words, you'll most likely set this with the time() function plus the number 
     * of seconds before you want it to expire.
     * If set to 0, or omitted, the cookie will expire at the end of the session (when the browser closes). 
     * 
     * @param string $key the name of the cookie item
     * @param int $expire expiration time
     * @return boolean return true if value was successfull set, false otherwise
     */
    public function setExpire($key, $expire) {
        return $this->setAttribute($key, 'expire', $expire);
    }
    
    /**
     * Sets the path on the server in which the cookie item will be available on.
     * If set to '/', the cookie will be available within the entire domain. 
     * If set to '/foo/', the cookie will only be available within the /foo/ directory 
     * and all sub-directories such as /foo/bar/ of domain.
     * 
     * @param string $key the name of the cookie item
     * @param string $path the path on the server
     * @return boolean return true if value was successfull set, false otherwise
     */
    public function setPath($key, $path) {
        return $this->setAttribute($key, 'path', $path);
    }
    
    /**
     * The (sub)domain that the cookie item is available to.
     * Setting this to a subdomain (such as 'www.example.com') will make the cookie 
     * available to that subdomain and all other sub-domains of it (i.e. w2.www.example.com). 
     * To make the cookie available to the whole domain (including all subdomains of it), 
     * simply set the value to the domain name ('example.com', in this case). 
     * 
     * @param string $key the name of the cookie item
     * @param string $domain the (sub)domain
     * @return boolean return true if value was successfull set, false otherwise
     */
    public function setDomain($key, $domain) {
        return $this->setAttribute($key, 'domain', $domain);
    }
    
    /**
     * Indicates that the cookie item should only be transmitted over a secure HTTPS 
     * connection from the client. When set to TRUE, the cookie will only be set 
     * if a secure connection exists.
     * 
     * @param string $key the name of the cookie item
     * @param boolean $secure true, if only transmitted over HTTPS
     * @return boolean return true if value was successfull set, false otherwise
     */
    public function setSecure($key, $secure) {
        return $this->setAttribute($key, 'secure', $secure);
    }
    
    /**
     * When TRUE the cookie will be made accessible only through the HTTP protocol.
     * This means that the cookie won't be accessible by scripting languages, such 
     * as JavaScript. It has been suggested that this setting can effectively help
     * to reduce identity theft through XSS attacks (although it is not supported 
     * by all browsers), but that claim is often disputed.
     * 
     * @param string $key the name of the cookie item
     * @param boolean $httpOnly true, if only accessible through HTTP
     * @return boolean return true if value was successfull set, false otherwise
     */
    public function setHttpOnly($key, $httpOnly) {
        return $this->setAttribute($key, 'expire', $httpOnly);
    }
    
    /**
     * Assigns a value to the specified cookie item.
     * 
     * @param string $key the name of the cookie item
     * @param mixed $value the (new) value
     */
    public function offsetSet($key, $value) {
        $this->setValue($key, $value);
    }

    /**
     * Whether or not the named ($key) cookie item exists.
     * 
     * @param string $key
     * @return boolean
     */
    public function offsetExists($key) {
        return isset($this->data[$key]);
    }

    /**
     * Removes a cookie item.
     * 
     * @param string $key the name of the cookie item, which should be removed
     */
    public function offsetUnset($key) {
        unset($this->data[$key]);
    }

    /**
     * Returns the value of the specified cookie item.
     * 
     * @param string $key the name of the cookie item
     * @return mixed the value of the the cookie item
     */
    public function offsetGet($key) {
        return $this->getValue($key);
    }
}
