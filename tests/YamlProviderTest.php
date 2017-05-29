<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test;

use PHPUnit\Framework\TestCase;
use Zelenin\Zend\Expressive\Config\Provider\YamlProvider;

final class YamlProviderTest extends TestCase
{
    public function testConfig()
    {
        $provider = new YamlProvider(__DIR__ . '/Resources/config.yml');

        $this->assertEquals(['foo' => 'bar'], $provider->getConfig());
    }
}
