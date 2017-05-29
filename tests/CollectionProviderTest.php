<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test;

use PHPUnit\Framework\TestCase;
use Zelenin\Zend\Expressive\Config\Provider\ArrayProvider;
use Zelenin\Zend\Expressive\Config\Provider\CollectionProvider;

final class CollectionProviderTest extends TestCase
{
    public function testConfig()
    {
        $provider = new CollectionProvider([
            new ArrayProvider(['foo' => 'bar']),
            new ArrayProvider(['bar' => 'foo']),
        ]);

        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $provider->getConfig());
    }
}
