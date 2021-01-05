<?php

namespace Limit0\Controller;

use Google\AdsApi\AdManager\v202011\NetworkService;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class HomeController
{
  /**
   * @var ContainerInterface
   */
  protected $container;

  /**
   * @param ContainerInterface $container
   */
  public function __construct(ContainerInterface $container)
  {
    $this->container = $container;
  }

  /**
   * @param Request $req
   * @param Response $res
   * @param array $args
   */
  public function index(Request $req, Response $res, array $args)
  {
    return $res->withJson(['ping' => 'pong']);
  }

  /**
   * @param Request $req
   * @param Response $res
   * @param array $args
   */
  public function health(Request $req, Response $res, array $args)
  {
    $factory = $this->container->get('ad-manager.service-factory');
    $networkService = $factory->service(NetworkService::class);
    $network = $networkService->getCurrentNetwork();

    return $res->withJson([
      'name' => $network->getDisplayName(),
      'code' => $network->getNetworkCode(),
    ]);
  }
}
