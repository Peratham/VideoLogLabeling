<?php
/**
 * The class map used to autoload the base classes.
 * New base classes should be added here!
 */
return [
    'app\Component' => APP_PATH . '/Component.php',
    'app\Module' => APP_PATH . '/Module.php',
    'app\Model' => APP_PATH . '/Model.php',
    'app\Controller' => APP_PATH . '/Controller.php',
    'app\View' => APP_PATH . '/View.php',
    'app\UrlManager' => APP_PATH . '/UrlManager.php',
    'app\Url' => APP_PATH . '/Url.php',
    'app\Request' => APP_PATH . '/Request.php',
    'app\Response' => APP_PATH . '/Response.php',
    'app\Cookie' => APP_PATH . '/Cookie.php',
    'app\Session' => APP_PATH . '/Session.php',
    'app\User' => APP_PATH . '/User.php',
    'app\IdentityInterface' => APP_PATH . '/IdentityInterface.php',
    'app\Html' => APP_PATH . '/Html.php',
    'app\Helper' => APP_PATH . '/Helper.php',
    'app\VarDumper' => APP_PATH . '/VarDumper.php',
    'app\ErrorHandler' => APP_PATH . '/exceptions/ErrorHandler.php',
    'app\Exception' => APP_PATH . '/exceptions/Exception.php',
    'app\HttpException' => APP_PATH . '/exceptions/HttpException.php',
    'app\NotFoundHttpException' => APP_PATH . '/exceptions/NotFoundHttpException.php',
    'app\ForbiddenHttpException' => APP_PATH . '/exceptions/ForbiddenHttpException.php',
];