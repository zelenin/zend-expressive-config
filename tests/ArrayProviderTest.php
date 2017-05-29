<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test;

use PHPUnit\Framework\TestCase;
use Zelenin\Zend\Expressive\Config\Provider\ArrayProvider;

final class ArrayProviderTest extends TestCase
{
    public function testConfig()
    {
        $config = [
            'foo' => 'bar',
        ];

        $provider = new ArrayProvider($config);

        $this->assertEquals($config, $provider->getConfig());
    }
}
