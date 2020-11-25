<?php

use Dotenv\Dotenv;
use Rosatom\Common\DBConnect;
use Slim\App;

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/modules/common/enableCors.php';

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$config = ['settings' => ['displayErrorDetails' => true]];
$app = new App($config);

DBConnect::init();


$app->run();
