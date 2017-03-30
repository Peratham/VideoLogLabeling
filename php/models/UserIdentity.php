<?php
namespace app\models;

/**
 * Description of UserIdentity
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class UserIdentity extends \app\Component implements \app\IdentityInterface
{
    protected $username;
    protected $password;
    protected $authKey;
    protected $accessToken;
    
    public function getAuthKey() {
        
    }

    public function getId() {
        
    }

    public function validateAuthKey($authKey) {
        
    }

    public static function findIdentity($id) {
        
    }

    public static function findIdentityByAccessToken($token, $type = null) {
        
    }
    
    public static function findIdentityByUsername($username) {
        foreach (\app\Application::$app->params['users'] as $user) {
            if(strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }
        return NULL;
    }
    
    public function validatePassword($password) {
        return $this->password === $password;
    }
}
