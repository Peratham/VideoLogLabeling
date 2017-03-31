<?php
/* @var $this app\View */
/* @var $model \app\modules\upload\models\Game */

$this->title = 'Upload ::: ' . \app\Application::$app->name;

$this->registerCssFile('style.css');
$this->registerCss('
    #new_game .panel-heading {
        font-weight: bold;
        font-size: 125%;
    }
');
// TODO: display errors
?>
<div class="row">
    <div class="col-sm-offset-3 col-sm-6">
        <div class="row">
            <div class="col-sm-12">
                <h1>Upload new game</h1>
            </div>
        </div>
        <?php if ($model->hasErrors()) : ?>
        <div class="row">
            <div class="col-sm-12">
                <?=  app\Html::getErrorSummary($model, [])?>
            </div>
        </div>
        <?php endif; ?>
        <form action="" method="post" id="new_game">
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Event info</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group required <?=$model->hasErrors('name')?'has-error':''?>">
                                        <?=app\Html::activeLabel($model, 'name', ['label'=>'Event'])?>
                                        <?=app\Html::activeInput($model, 'name', ['class'=>'form-control', 'maxlength'=>'50', 'placeholder'=>'Name of the event'])?>
                                        <?=app\Html::activeError($model, 'name', [], TRUE)?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group required <?=$model->hasErrors('name')?'has-error':''?>">
                                        <?=app\Html::activeLabel($model, 'date', ['label'=>'Date'])?>
                                        <?=app\Html::activeInput($model, 'date', ['type'=>'date', 'class'=>'form-control', 'placeholder'=>'Date'])?>
                                        <?=app\Html::activeError($model, 'name', [], TRUE)?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Team #1</div>
                        <div class="panel-body">
                            <div class="form-group required">
                                <?=app\Html::activeLabel($model, 'team1_id', ['label'=>'Name'])?>
                                <?=app\Html::activeDropdown($model, 'team1_id', ['class'=>'form-control', 'items'=>\app\Application::$app->params['teams'], 'prompt'=>''])?>
                            </div>
                            <div class="form-group">
                                <?=app\Html::activeLabel($model, 'team1_half1', ['label'=>'First half log files'])?>
                                <?=app\Html::activeInput($model, 'team1_half1', ['type'=>'file', 'class'=>'form-control', 'placeholder'=>'file'])?>
                            </div>
                            <div class="form-group">
                                <?=app\Html::activeLabel($model, 'team1_half2', ['label'=>'Second half log files'])?>
                                <?=app\Html::activeInput($model, 'team1_half2', ['type'=>'file', 'class'=>'form-control', 'placeholder'=>'file'])?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Team #2</div>
                        <div class="panel-body">
                            <div class="form-group required">
                                <?=app\Html::activeLabel($model, 'team2_id', ['label'=>'Name'])?>
                                <?=app\Html::activeDropdown($model, 'team2_id', ['class'=>'form-control', 'items'=>\app\Application::$app->params['teams'], 'prompt'=>''])?>
                            </div>
                            <div class="form-group">
                                <?=app\Html::activeLabel($model, 'team2_half1', ['label'=>'First half log files'])?>
                                <?=app\Html::activeInput($model, 'team2_half1', ['type'=>'file', 'class'=>'form-control', 'placeholder'=>'file'])?>
                            </div>
                            <div class="form-group">
                                <?=app\Html::activeLabel($model, 'team2_half2', ['label'=>'Second half log files'])?>
                                <?=app\Html::activeInput($model, 'team2_half2', ['type'=>'file', 'class'=>'form-control', 'placeholder'=>'file'])?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">GameController</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?=app\Html::activeLabel($model, 'gc_half1', ['label'=>'First half log files'])?>
                                        <?=app\Html::activeInput($model, 'gc_half1', ['type'=>'file', 'class'=>'form-control', 'placeholder'=>'file'])?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?=app\Html::activeLabel($model, 'gc_half2', ['label'=>'Second half log files'])?>
                                        <?=app\Html::activeInput($model, 'gc_half2', ['type'=>'file', 'class'=>'form-control', 'placeholder'=>'file'])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">Video files</div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?=app\Html::activeLabel($model, 'video_half1', ['label'=>'First half video files'])?>
                                        <?=app\Html::activeInput($model, 'video_half1', ['type'=>'file', 'class'=>'form-control', 'placeholder'=>'file'])?>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <?=app\Html::activeLabel($model, 'video_half2', ['label'=>'Second half video files'])?>
                                        <?=app\Html::activeInput($model, 'video_half2', ['type'=>'file', 'class'=>'form-control', 'placeholder'=>'file'])?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-xs-offset-8">
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Submit</button>
                </div>
            </div>
        </form>
    </div>
</div>
<p>&nbsp;</p>
<div id="watermark"></div>
