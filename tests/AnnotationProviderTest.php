<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test;

use PHPUnit\Framework\TestCase;
use Zelenin\Zend\Expressive\Config\Provider\AnnotationProvider;
use Zelenin\Zend\Expressive\Config\Test\Resources\FactoryWithAnnotation;
use Zelenin\Zend\Expressive\Config\Test\Resources\InvokableWithAnnotation;
use Zelenin\Zend\Expressive\Config\Test\Resources\MiddlewareWithAnnotation;
use Zelenin\Zend\Expressive\Config\Test\Resources\ModuleConfigProvider;
use Zelenin\Zend\Expressive\Config\Test\Resources\RouteWithAnnotation;
use Zelenin\Zend\Expressive\Config\Util\ClassNameExtractor;

final class AnnotationProviderTest extends TestCase
{
    public function testConfig()
    {
        $provider = new AnnotationProvider(__DIR__ . '/Resources/');

        $this->assertEquals([
            'dependencies' => [
                'factories' => [
                    'serviceId' => FactoryWithAnnotation::class,
                ],
                'invokables' => [
                    InvokableWithAnnotation::class => InvokableWithAnnotation::class,
                ],
            ],
            'middleware_pipeline' => [
                [
                    'path' => '/path',
                    'middleware' => MiddlewareWithAnnotation::class,
                ],
            ],
            'routes' => [
                [
                    'path' => '/path',
                    'middleware' => RouteWithAnnotation::class,
                    'name' => 'route-name',
                    'allowed_methods' => ['GET', 'POST'],
                ],
            ],
        ], $provider->getConfig());
    }

    public function testClassNameExtractor()
    {
        $extractor = new ClassNameExtractor();

        $this->assertEquals(ModuleConfigProvider::class, $extractor->getClassName(file_get_contents(__DIR__ . '/Resources/ModuleConfigProvider.php')));

        $this->assertEquals(FactoryWithAnnotation::class, $extractor->getClassName(file_get_contents(__DIR__ . '/Resources/FactoryWithAnnotation.php')));
    }
}
