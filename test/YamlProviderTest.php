<?php

namespace Zelenin\Zend\Expressive\Config\Test;

use PHPUnit_Framework_TestCase;
use Zelenin\Zend\Expressive\Config\Provider\YamlProvider;

final class YamlProviderTest extends PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $provider = new YamlProvider(__DIR__ . '/Resources/config.yml');

        $this->assertEquals(['foo' => 'bar'], $provider->getConfig());
    }
}
