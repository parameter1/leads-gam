<?php
require '../vendor/autoload.php';

use \Psr\Http\Message\ServerRequestInterface as Request;
use \Psr\Http\Message\ResponseInterface as Response;
use Google\AdsApi\AdManager\v201811\NetworkService;
use Limit0\Test;
use Limit0\AdManager\ServiceFactory;

$app = new \Slim\App;
$app->get('/', function(Request $req, Response $res, array $args) {
  $factory = new ServiceFactory();
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
