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
    
    protected function init() {
    }
    
    public function getIsGuest() {
        return TRUE;
    }
}
