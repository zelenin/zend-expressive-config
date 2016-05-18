<?php

namespace Zend\Expressive\Config\Test;

use PHPUnit_Framework_TestCase;
use Zelenin\Zend\Expressive\Config\Provider\ArrayProvider;
use Zelenin\Zend\Expressive\Config\Provider\CollectionProvider;

final class CollectionProviderTest extends PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $provider = new CollectionProvider([
            new ArrayProvider(['foo' => 'bar']),
            new ArrayProvider(['bar' => 'foo'])
        ]);

        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $provider->getConfig());
    }
}
