<?php
declare(strict_types=1);
require_once(__DIR__.'../../vendor/autoload.php');
require_once(__DIR__.'../../src/container.php');

use PHPUnit\Framework\TestCase;

final class ContainerTest extends TestCase {
  public function testTrue(): void {
    global $container;
    $this->assertIsCallable([$container, 'get'], 'Unable to call `get` on the container.');
  }
}
