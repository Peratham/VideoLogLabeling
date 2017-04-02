<?php
namespace app;

/**
 * Description of User
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class User extends Component
{
    /**
     * @var FALSE|NULL|IdentityInterface if logged-in - the currently used user model/object
     */
    private $_identity = FALSE;
    /**
     * @var string the session variable name where the return URL is stored
     */
    protected $returnUrlKey = '__returnUrl';
    /**
     * @var string the session/cookie variable name where the user ID is stored
     */
    protected $idParam = '__id';
    /**
     * @var string the name of the class implmenting the IdentityInterface and therefore representing a (logged-in) user
     */
    public $userClass;
    /**
     * @var string|array the URL, where the user can login (authenticate)
     */
    public $loginUrl = ['default/login'];
    /**
     * @var boolean indicating the use of sessions for restoring login state
     */
    public $enableSession = TRUE;
    /**
     * @var boolean use cookies for auto-login on later request/visit
     */
    public $enableCookieAutoLogin = TRUE;
    /**
     * @var boolean on each new request, update expirartion time of the user cookie
     */
    public $autoRenewCookie = TRUE;
    
    /**
     * Initializes the component.
     * If the $userClass wasn't set, an Exception is thrown. We need to set the
     * user class explicitly, otherwise we wouldn't know which class represents
     * an user object/model and which needs to be instantiated on user login.
     * 
     * @throws InvalidConfigException
     */
    protected function init() {
        if($this->userClass === NULL) {
            throw new InvalidConfigException('A user identity class must be set.');
        }
    }
    
    /**
     * 
     * @param type $autoRenew
     * @return type
     */
    public function getIdentity($autoRenew = true) {
        if ($this->_identity === FALSE) {
            if ($this->enableSession && $autoRenew) {
                $this->_identity = NULL;
                $this->renewAuthStatus();
            } else {
                return NULL;
            }
        }

        return $this->_identity;
    }
    
    protected function renewAuthStatus() {
        $session = \app\Application::$app->getSession();
        $id = $session->isActive() ? $session->get($this->idParam) : NULL;

        $user = NULL;
        if($id !== NULL) {
            /* @var $class IdentityInterface */
            $class = $this->userClass;
            if(($config = $class::findIdentity($id)) !== NULL) {
                $user = new $class($config);
            }
        }

        $this->setIdentity($user);

        if ($this->enableCookieAutoLogin) {
            if ($this->getIsGuest()) {
                $this->loginByCookie();
            } elseif ($this->autoRenewCookie) {
                $this->renewUserCookie();
            }
        }
    }
    
    /**
     * Checks, whether the user is logged-in (false) or not (true).
     * @return boolean
     */
    public function getIsGuest() {
        return $this->getIdentity() === NULL;
    }
    
    public function login(IdentityInterface $identity, $duration = 0) {
        $this->switchIdentity($identity, $duration);
        return !$this->getIsGuest();
    }
    
    protected function sendUserCookie($identity, $duration) {
        $this->sendUserCookieInternal($identity->getId(), $identity->getAuthKey(), $duration);
    }
        
    private function sendUserCookieInternal($id, $authkey, $duration) {
        Application::$app->response->cookie->setValue(
            $this->idParam, // cookie key
            json_encode([ $id, $authkey, $duration, ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), // cookie value
            time() + $duration // cookie expiration time
        );
    }
    
    protected function loginByCookie() {
        $value = Application::$app->request->cookie[$this->idParam];
        if ($value !== NULL) {
            $data = json_decode($value, true);
            if (count($data) == 3) {
                /* @var $class IdentityInterface */
                $class = $this->userClass;
                $config = $class::findIdentity($data[0]);
                if ($config !== NULL) {
                    $user = new $class($config);
                    if($user->validateAuthKey($data[1])) {
                        $this->switchIdentity($user, $this->autoRenewCookie ? $data[2] : 0);
                        return;
                    }
                }
            }
            // an "error" occured above - remove user cookie
            $this->removeUserCookie();
        }
    }
    
    protected function renewUserCookie() {
        $value = Application::$app->request->cookie[$this->idParam];
        if ($value !== NULL) {
            $data = json_decode($value, true);
            if (is_array($data) && isset($data[2])) {
                $this->sendUserCookieInternal($data[0], $data[1], (int) $data[2]);
            }
        }
    }
    
    protected function removeUserCookie() {
        if ($this->enableCookieAutoLogin) {
            Application::$app->response->cookie->remove($this->idParam);
        }
    }


    public function logout($destroySession = true) {
        $identity = $this->getIdentity();
        if ($identity !== NULL) {
            $this->switchIdentity(NULL);
            if ($destroySession && $this->enableSession) {
                Application::$app->getSession()->destroy();
            }
        }

        return $this->getIsGuest();
    }
    
    public function setIdentity($identity) {
        if ($identity instanceof IdentityInterface) {
            $this->_identity = $identity;
        } elseif ($identity === NULL) {
            $this->_identity = NULL;
        } else {
            throw new InvalidValueException('The identity object must implement IdentityInterface.');
        }
    }
    
    public function switchIdentity($identity, $duration = 0) {
        $this->setIdentity($identity);

        if (!$this->enableSession) {
            return;
        }

        /* Ensure any existing identity cookies are removed. */
        $this->removeUserCookie();

        $session = Application::$app->getSession();
        $session->regenerateId(TRUE);
        // remove old user ID
        $session->remove($this->idParam);
        // if identity is valid ...
        if ($identity) {
            // ... set new user ID
            $session->set($this->idParam, $identity->getId());
            // and set the cookie for autologin
            if ($duration > 0 && $this->enableCookieAutoLogin) {
                $this->sendUserCookie($identity, $duration);
            }
        }
    }
    
    public function setReturnUrl($url) {
        Application::$app->session->set($this->returnUrlKey, $url);
    }
    
    public function getReturnUrl($default = NULL) {
        $url = Application::$app->session->get($this->returnUrlKey, $default);
        return $url === NULL ? \app\Url::home() : \app\Url::to([$url]);
    }
}
