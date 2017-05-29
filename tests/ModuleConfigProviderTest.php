<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test;

use PHPUnit\Framework\TestCase;
use Zelenin\Zend\Expressive\Config\Test\Resources\ModuleConfigProvider;

final class ModuleConfigProviderTest extends TestCase
{
    public function testConfig()
    {
        $provider = new ModuleConfigProvider();

        $this->assertEquals(['bar' => 'foo'], $provider->getConfig());
    }
}
