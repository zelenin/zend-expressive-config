<?php

namespace Zend\Expressive\Config\Test;

use PHPUnit_Framework_TestCase;
use Zelenin\Zend\Expressive\Config\Provider\ArrayProvider;

final class ArrayProviderTest extends PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $config = [
            'foo' => 'bar'
        ];

        $provider = new ArrayProvider($config);

        $this->assertEquals($config, $provider->getConfig());
    }
}
