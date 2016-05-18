<?php

namespace Zend\Expressive\Config\Test;

use PHPUnit_Framework_TestCase;
use Zelenin\Zend\Expressive\Config\ConfigManager;
use Zelenin\Zend\Expressive\Config\Provider\PhpProvider;
use Zend\Expressive\Config\Test\Resources\ModuleConfigProvider;

final class ConfigManagerTest extends PHPUnit_Framework_TestCase
{
    public function testConfig()
    {
        $providers = [
            new PhpProvider(__DIR__ . '/Resources/config.php'),
            new ModuleConfigProvider()
        ];

        $manager = new ConfigManager($providers);

        $this->assertEquals(['foo' => 'bar', 'bar' => 'foo'], $manager->getConfig());
    }
}
