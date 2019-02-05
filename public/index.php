<?php
require '../vendor/autoload.php';
require '../src/container.php';

use Limit0\Controller\HomeController;
use Limit0\Controller\AdManagerController;
use Slim\App;

$app = new App($container);
$app->get('/', HomeController::class . ':index');
$app->get('/_health', HomeController::class . ':health');
$app->get('/lineitem-detail/{lid:[a-z0-9]+}/{cid:[a-z0-9]+}', AdManagerController::class . ':lineItemCreativeDetails');
$app->run();
