<?php
/* @var $this app\View */
/* @var $model \app\modules\upload\models\Game */

use app\Html;

$this->title = 'Upload ::: ' . \app\Application::$app->name;

$this->registerCssFile('style.css');
$this->registerCss('
    #new_game .panel-heading {
        font-weight: bold;
        font-size: 125%;
    }
');
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
                <?=Html::getErrorSummary($model, [])?>
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
                                    <?=Html::activeFormField($model, 'name', ['required'=>TRUE, 'labelOptions'=>['label'=>'Event'], 'inputOptions'=>['maxlength'=>'50', 'placeholder'=>'Name of the event']])?>
                                </div>
                                <div class="col-sm-6">
                                    <?=Html::activeFormField($model, 'date', ['required'=>TRUE, 'labelOptions'=>['label'=>'Date'], 'inputOptions'=>['type'=>'date', 'placeholder'=>'Date']])?>
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
                            <?=Html::activeFormField($model, 'team1_id', ['required'=>TRUE, 'labelOptions'=>['label'=>'Name'], 'inputOptions'=>['type'=>'dropdown', 'items'=>\app\Application::$app->params['teams'], 'prompt'=>'']])?>
                            <?=Html::activeFormField($model, 'team1_half1', ['labelOptions'=>['label'=>'First half log files'], 'inputOptions'=>['type'=>'file', 'placeholder'=>'file']])?>
                            <?=Html::activeFormField($model, 'team1_half2', ['labelOptions'=>['label'=>'Second half log files'], 'inputOptions'=>['type'=>'file', 'placeholder'=>'file']])?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-default">
                        <div class="panel-heading">Team #2</div>
                        <div class="panel-body">
                            <?=Html::activeFormField($model, 'team2_id', ['required'=>TRUE, 'labelOptions'=>['label'=>'Name'], 'inputOptions'=>['type'=>'dropdown', 'items'=>\app\Application::$app->params['teams'], 'prompt'=>'']])?>
                            <?=Html::activeFormField($model, 'team2_half1', ['labelOptions'=>['label'=>'First half log files'], 'inputOptions'=>['type'=>'file', 'placeholder'=>'file']])?>
                            <?=Html::activeFormField($model, 'team2_half2', ['labelOptions'=>['label'=>'Second half log files'], 'inputOptions'=>['type'=>'file', 'placeholder'=>'file']])?>
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
                                    <?=Html::activeFormField($model, 'gc_half1', ['labelOptions'=>['label'=>'First half log files'], 'inputOptions'=>['type'=>'file', 'placeholder'=>'file']])?>
                                </div>
                                <div class="col-sm-6">
                                    <?=Html::activeFormField($model, 'gc_half2', ['labelOptions'=>['label'=>'Second half log files'], 'inputOptions'=>['type'=>'file', 'placeholder'=>'file']])?>
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
                                    <?=Html::activeFormField($model, 'video_half1', ['labelOptions'=>['label'=>'First half video files'], 'inputOptions'=>['type'=>'file', 'placeholder'=>'file']])?>
                                </div>
                                <div class="col-sm-6">
                                    <?=Html::activeFormField($model, 'video_half1', ['labelOptions'=>['label'=>'Second half video files'], 'inputOptions'=>['type'=>'file', 'placeholder'=>'file']])?>
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
