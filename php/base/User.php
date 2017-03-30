<?php
namespace app;

/**
 * Description of User
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class User extends Component {
    
    public $loginUrl = ['default/login'];
    
    public $returnUrlKey = '__returnUrl';
    
    public $enableSession = TRUE;
    private $_identity = NULL;
    
    protected function init() {
    }
    
    public function getIsGuest() {
        return TRUE;
    }
    
    public function login(IdentityInterface $identity, $duration = 0) {
        $this->setIdentity($identity);
        /*
        // TODO: implement User login method!!
        if (!$this->enableSession) {
            return;
        }

        /* Ensure any existing identity cookies are removed. * /
        if ($this->enableAutoLogin) {
            $this->removeIdentityCookie();
        }

        $session = Yii::$app->getSession();
        if (!YII_ENV_TEST) {
            $session->regenerateID(true);
        }
        $session->remove($this->idParam);
        $session->remove($this->authTimeoutParam);

        if ($identity) {
            $session->set($this->idParam, $identity->getId());
            if ($this->authTimeout !== null) {
                $session->set($this->authTimeoutParam, time() + $this->authTimeout);
            }
            if ($this->absoluteAuthTimeout !== null) {
                $session->set($this->absoluteAuthTimeoutParam, time() + $this->absoluteAuthTimeout);
            }
            if ($duration > 0 && $this->enableAutoLogin) {
                $this->sendIdentityCookie($identity, $duration);
            }
        }
        */

        return !$this->getIsGuest();
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
}
