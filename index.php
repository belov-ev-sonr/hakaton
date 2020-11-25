<?php

use Dotenv\Dotenv;
use Rosatom\Auth\Presentation\AuthRouter;
use Rosatom\Common\DBConnect;
use Rosatom\FinReport\FinReportRoute;
use Rosatom\RateCurrencies\Presentation\RateOfCurrencyRouter;
use Rosatom\Reports\Presentation\ReportsRouter;
use Rosatom\User\Presentation\UserRouter;
use Slim\App;

require_once $_SERVER['DOCUMENT_ROOT'] . '/src/vendor/autoload.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/src/modules/common/enableCors.php';

$dotenv = Dotenv::create(__DIR__);
$dotenv->load();

$config = ['settings' => ['displayErrorDetails' => true]];
$app = new App($config);

DBConnect::init();

$app->group('/reports', function () {
    return new ReportsRouter($this);
});

$app->group('/auth', function () {
    return new AuthRouter($this);
});

$app->group('/user', function () {
    return new UserRouter($this);
});

$app->group('/rateOfCurrency', function () {
    return new RateOfCurrencyRouter($this);
});

$app->group('/finreport', function () {
    return new FinReportRoute($this);
});


$app->run();
