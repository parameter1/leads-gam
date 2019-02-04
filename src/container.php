<?php

use Slim\Container;
use Limit0\AdManager\ServiceFactory;

$container = new Container();
$container['ad-manager.service-factory'] = function() {
  return new ServiceFactory();
};
