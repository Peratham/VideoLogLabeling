<?php
namespace app\models;

use app\Validator;

/**
 * Description of UserIdentity
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class User extends \app\Model implements \app\IdentityInterface
{
    public $id;
    public $username;
    public $password;
    public $remember;
    public $authKey;
    public $accessToken;
    
    public function getAuthKey() {
        return $this->authKey;
    }

    public function getId() {
        return $this->id;
    }

    public function validateAuthKey($authKey) {
        return $this->authKey === $authKey;
    }

    public static function findIdentity($id) {
        foreach (\app\Application::$app->params['users'] as $user) {
            if(strcasecmp($user['id'], $id) === 0) {
                return $user;
            }
        }
        return NULL;
    }

    public static function findIdentityByAccessToken($token) {
        foreach (\app\Application::$app->params['users'] as $user) {
            if(strcasecmp($user['accessToken'], $token) === 0) {
                return $user;
            }
        }
        return NULL;
    }
    
    public static function findIdentityByUsername($username) {
        foreach (\app\Application::$app->params['users'] as $user) {
            if(strcasecmp($user['username'], $username) === 0) {
                return $user;
            }
        }
        return NULL;
    }
    
    public function validatePassword($password) {
        return $this->password === $password;
    }

    public function save() {
        return FALSE;
    }

    public function validate() {
        Validator::required($this, 'username');
        Validator::required($this, 'password');
        Validator::boolean($this, 'remember');
        
        if(!$this->hasErrors()) {
            $config = static::findIdentityByUsername($this->username);
            if($config === NULL || !$this->validatePassword($config['password'])) {
                $this->addError('password', 'Incorrect username or password.');
            } else {
                $this->authKey = $config['authKey'];
                $this->accessToken = $config['accessToken'];
                $this->id = $config['id'];
            }
        }
        
        return !$this->hasErrors();
    }

}
