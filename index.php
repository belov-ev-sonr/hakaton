<?php

use Dotenv\Dotenv;
use Rosseti\Common\DBConnect;
use Slim\App;
use UserLk\UserLkRouter;
use ApplicationCrud\ApplicationRout;
use OtherRoute\OtherRout;

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/modules/common/enableCors.php';

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$config = ['settings' => ['displayErrorDetails' => true]];
$app = new App($config);

DBConnect::init();


$app->group('', function () use ($app) {
    $app->group('/application', function () {
        return new ApplicationRout($this);
    });
    $app->group('/other', function () {
        return new OtherRout($this);
    });
    $app->group('/userLk', function () {
        return new UserLkRouter($this);
    });
});
try {
    $app->run();
} catch (Throwable $e) {
    print_r($e->getMessage());
    print_r($e->getCode());
    print_r($e->getFile());
    print_r($e->getLine());
    print_r($e->getTraceAsString());
};

