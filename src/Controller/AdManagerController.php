<?php

namespace Limit0\Controller;

use Google\AdsApi\AdManager\v201811\CreativeService;
use Google\AdsApi\AdManager\v201811\LineItemService;
use Google\AdsApi\AdManager\Util\v201811\StatementBuilder;
use Google\AdsApi\AdManager\Util\v201811\AdManagerDateTimes;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

class AdManagerController
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
  public function lineItemCreativeDetails(Request $req, Response $res, array $args)
  {
    $cid = $args['cid'];
    $lid = $args['lid'];

    [$creative, $lineitem] = $this->getCreativeDetails($cid, $lid);
    if (!$creative || !$lineitem) return $res->withJson(['creative' => null]);

    $classParts = explode('\\', get_class($creative));
    $creativeType = str_replace('Creative', '', array_pop($classParts));

    $dateMap = [
      'startDate' => 'getStartDateTime',
      'endDate' => 'getEndDateTime',
      'createdDate' => 'getCreationDateTime',
      'updatedDate' => 'getLastModifiedDateTime',
    ];

    $metrics = [];
    $stats = $lineitem->getStats();
    if ($stats) {
      foreach (get_class_methods($stats) as $method) {
        if (0 === stripos($method, 'get')) {
          $metrics[lcfirst(str_replace('get', '', $method))] = $stats->$method();
        }
      }
    }

    $result = [
      'id' => $cid,
      'name' => $creative->getName(),
      'type' => $creativeType,
      'width' => $creative->getSize()->getWidth(),
      'height' => $creative->getSize()->getHeight(),
      'previewUrl' => $creative->getPreviewUrl(),
      'advertiser' => [
        'id' => (string) $creative->getAdvertiserId(),
      ],
      'order' => [
        'id' => (string) $lineitem->getOrderId(),
        'name' => $lineitem->getOrderName(),
      ],
      'lineitem' => [
        'id' => (string) $lineitem->getId(),
        'name' => $lineitem->getName(),
        'metrics' => $metrics,
      ],
    ];
    if (method_exists($creative, 'getVastPreviewUrl')) {
      $result['vastPreviewUrl'] = $creative->getVastPreviewUrl();
    }
    // Set creative and line item dates.
    foreach ($dateMap as $key => $method) {
      foreach (['creative', 'lineitem'] as $type) {
        if (method_exists($$type, $method) && $$type->$method()) {
          $timestamp = AdManagerDateTimes::toDateTime($$type->$method())->getTimestamp() * 1000;
          if ('creative' === $type) {
            $result[$key] = $timestamp;
          } else {
            $result[$type][$key] = $timestamp;
          }
        }
      }
    }
    return $res->withJson(['creative' => $result]);
  }

  /**
   *
   */
  private function getCreativeDetails($cid, $lid)
  {
    $factory = $this->container->get('ad-manager.service-factory');

    $creativeService = $factory->service(CreativeService::class);
    $lineItemService = $factory->service(LineItemService::class);

    $creatives = $creativeService->getCreativesByStatement(
      (new StatementBuilder())->where(sprintf('id = %s', $cid))->toStatement()
    )->getResults();
    $creative = isset($creatives[0]) ? $creatives[0] : null;

    $lineItems = $lineItemService->getLineItemsByStatement(
      (new StatementBuilder())->where(sprintf('id = %s', $lid))->toStatement()
    )->getResults();
    $lineItem = isset($lineItems[0]) ? $lineItems[0] : null;

    return [$creative, $lineItem];
  }
}
