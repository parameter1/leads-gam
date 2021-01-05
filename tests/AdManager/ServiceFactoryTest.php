<?php
declare(strict_types=1);
require_once(__DIR__.'../../../vendor/autoload.php');

use PHPUnit\Framework\TestCase;
use Limit0\AdManager\ServiceFactory;

final class ServiceFactoryTest extends TestCase {
  public function testCallable(): void {
    $factory = new ServiceFactory();
    $this->assertIsCallable([$factory, 'service']);
  }
}
