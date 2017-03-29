<?php
/* @var $this app\View */

$this->title = \app\Application::$app->name . ' ::: Login';
$this->registerCssFile('style.css');

$hasError = !empty($error);
?>
<div class="row">
    <div class="col-sm-offset-3 col-sm-6">
        <h1>Login</h1>
        <div class="row">
            <div class="col-sm-12">
                <p>Please fill out the following fields to login:</p>
                <form action="<?=\app\Url::to([''])?>" method="post" class="form-horizontal <?=$hasError?'has-error':''?>">
                    <?=$hasError?'<div class="alert alert-danger" role="alert">'.$error.'</div>':''?>
                    <div class="form-group">
                        <label for="login_mail" class="col-sm-2 control-label">Email</label>
                        <div class="col-sm-10">
                            <input type="email" class="form-control" id="login_mail" name="Login[mail]" placeholder="Email">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="login_pass" class="col-sm-2 control-label">Password</label>
                        <div class="col-sm-10">
                            <input type="password" class="form-control" id="login_pass" name="Login[password]" placeholder="Password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-2 col-sm-10">
                            <div class="checkbox">
                                <label>
                                    <input type="hidden" name="Login[remember]" value="0">
                                    <input type="checkbox" name="Login[remember]" value="1"> Remember me
                                </label>
                            </div>
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