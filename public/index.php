<?php
require '../vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Limit0\Test;

$app = new \Slim\App;
$app->get('/', function(Request $req, Response $res, array $args) {
  $data = ['ping' => 'pong', 'foo' => Test::foo()];
  return $res->withJson($data);
});
$app->run();
