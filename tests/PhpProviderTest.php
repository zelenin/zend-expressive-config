<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test;

use PHPUnit\Framework\TestCase;
use Zelenin\Zend\Expressive\Config\Provider\PhpProvider;

final class PhpProviderTest extends TestCase
{
    public function testConfig()
    {
        $provider = new PhpProvider(__DIR__ . '/Resources/config.php');

        $this->assertEquals(['foo' => 'bar'], $provider->getConfig());
    }
}
