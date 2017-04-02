<?php
/* @var $this app\View */
/* @var $model \app\models\User */

use app\Html;

$this->title = 'Login ::: '.\app\Application::$app->name;
$this->registerCssFile('style.css');

$hasError = !empty($error);
?>
<div class="row">
    <div class="col-sm-offset-3 col-sm-6">
        <h1>Login</h1>
        <div class="row">
            <div class="col-sm-12">
                <p>Please fill out the following fields to login:</p>
                <form action="<?=\app\Url::to([''])?>" method="post" class="form-horizontal <?=$model->hasErrors()?'has-error':''?>">
                    <?=$hasError?'<div class="alert alert-danger" role="alert">'.$error.'</div>':''?>
                    <div class="form-group">
                        <?=Html::activeLabel($model, 'username', ['label'=>'Email', 'class'=>'col-sm-2 control-label'])?>
                        <div class="col-sm-10">
                            <?=Html::activeInput($model, 'username', ['type'=>'email', 'placeholder'=>'Email'])?>
                            <?=Html::activeError($model, 'username', [], TRUE)?>
                        </div>
                    </div>
                    <div class="form-group">
                        <?=Html::activeLabel($model, 'password', ['label'=>'Password', 'class'=>'col-sm-2 control-label'])?>
                        <div class="col-sm-10">
                            <?=Html::activeInput($model, 'password', ['type'=>'password', 'placeholder'=>'Password'])?>
                            <?=Html::activeError($model, 'password', [], TRUE)?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <?=Html::activeCheckbox($model, 'remember', ['label'=>'Remember me'])?>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <button type="submit" class="btn btn-default">Sign in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<div id="watermark"></div>