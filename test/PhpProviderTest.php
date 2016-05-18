<?php

namespace Zend\Expressive\Config\Test;

use PHPUnit_Framework_TestCase;
use Zelenin\Zend\Expressive\Config\Provider\PhpProvider;

final class PhpProviderTest extends PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $provider = new PhpProvider(__DIR__ . '/Resources/config.php');

        $this->assertEquals(['foo' => 'bar'], $provider->getConfig());
    }
}
