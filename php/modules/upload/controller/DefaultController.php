<?php
namespace app\modules\upload\controller;

use app\Application;
use app\modules\upload\models\Game;

/**
 * Description of DefaultController
 *
 * @author Philipp Strobel <philippstrobel@posteo.de>
 */
class DefaultController extends \app\Controller
{
    protected function access($action) {
        return TRUE;//!\app\Application::$app->user->isGuest;
    }
    
    public function actionIndex() {
        $model = new Game();
        
        if(Application::$app->request->isPost && $model->load(Application::$app->request->post('Game'))) {
            echo \app\VarDumper::dumpAsString($model);
            echo \app\VarDumper::dumpAsString(Application::$app->request->post('Game'));
            if($model->validate() && $model->save()) {
                return Application::$app->response->redirect('success');
            }
        }
        
        return $this->render('index', ['model'=>$model]);
    }

}
