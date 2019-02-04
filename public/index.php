<?php
require '../vendor/autoload.php';
require '../src/container.php';

use Limit0\Controller\HomeController;
use Slim\App;

$app = new App($container);
$app->get('/', HomeController::class . ':index');
$app->run();
