<?php
require '../vendor/autoload.php';
require 'container.php';

use Google\AdsApi\AdManager\v201811\NetworkService;
use Slim\App;
use \Psr\Http\Message\ResponseInterface as Response;
use \Psr\Http\Message\ServerRequestInterface as Request;

$app = new App($container);
$app->get('/', function(Request $req, Response $res, array $args) {
  $factory = $this->get('ad-manager.service-factory');
  $networkService = $factory->service(NetworkService::class);
  $network = $networkService->getCurrentNetwork();

  $res->getBody()->write(sprintf(
    '<pre>%s (%s)</pre>',
    $network->getDisplayName(),
    $network->getNetworkCode()
  ));
  return $res;
});
$app->run();
