<?php
namespace app\modules\upload\controller;

/**
 * Description of DefaultController
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class DefaultController extends \app\Controller
{
    protected function access($action) {
        return !\app\Application::$app->user->isGuest;
    }
    
    public function actionIndex() {
        return $this->render('index');
    }

}
