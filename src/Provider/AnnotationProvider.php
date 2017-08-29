<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider;

use Composer\Autoload\ClassLoader;
use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\IndexedReader;
use Doctrine\Common\Annotations\Reader;
use InvalidArgumentException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use ReflectionClass;
use RegexIterator;
use Zelenin\Zend\Expressive\Config\Provider\Annotation\Factory;
use Zelenin\Zend\Expressive\Config\Provider\Annotation\Inject;
use Zelenin\Zend\Expressive\Config\Provider\Annotation\Invokable;
use Zelenin\Zend\Expressive\Config\Provider\Annotation\Middleware;
use Zelenin\Zend\Expressive\Config\Provider\Annotation\Route;
use Zelenin\Zend\Expressive\Config\Provider\FactoryGenerator\FactoryGenerator;
use Zelenin\Zend\Expressive\Config\Util\ClassNameExtractor;

final class AnnotationProvider implements Provider
{
    /**
     * @var Reader
     */
    private $reader;

    /**
     * @var string
     */
    private $path;

    /**
     * @var FactoryGenerator
     */
    private $factoryGenerator;

    /**
     * @var string
     */
    private $factoryPath;

    /**
     * @var ClassNameExtractor
     */
    private $classNameExtractor;

    public function __construct(string $path, string $factoryPath)
    {
        $this->reader = new IndexedReader(new AnnotationReader());
        $this->path = $path;
        $this->factoryPath = $factoryPath;
        $this->factoryGenerator = new FactoryGenerator($this->factoryPath);
        $this->classNameExtractor = new ClassNameExtractor();

        $this->registerLoader();
    }

    /**
     * @inheritdoc
     */
    public function getConfig(): array
    {
        $config = [];

        $recursiveIterator = new RecursiveIteratorIterator(new RecursiveDirectoryIterator($this->path));
        $iterator = new RegexIterator($recursiveIterator, '/^.+\.php$/i', RecursiveRegexIterator::GET_MATCH);

        foreach ($iterator as $filePath) {
            $content = file_get_contents($filePath[0]);
            $className = $this->classNameExtractor->getClassName($content);

            if ($className) {
                $reflClass = new ReflectionClass($className);
                $classAnnotations = $this->reader->getClassAnnotations($reflClass);

                if (isset($classAnnotations[Factory::class])) {
                    /** @var Factory $annotation */
                    $annotation = $classAnnotations[Factory::class];
                    $config['dependencies']['factories'][$annotation->id] = $className;
                }

                if (isset($classAnnotations[Invokable::class])) {
                    /** @var Factory $annotation */
                    $annotation = $classAnnotations[Invokable::class];
                    $id = $annotation->id ?: $className;
                    $config['dependencies']['invokables'][$id] = $className;
                }

                if (isset($classAnnotations[Middleware::class])) {
                    /** @var Middleware $annotation */
                    $annotation = $classAnnotations[Middleware::class];
                    $middleware = [
                        'path' => $annotation->path,
                        'middleware' => $className,
                    ];

                    if (!empty($annotation->priority) && is_int($annotation->priority)) {
                        $middleware['priority'] = $annotation->priority;
                    }

                    if (!empty($annotation->name)) {
                        $config['middleware_pipeline'][$annotation->name] = $middleware;
                    } else {
                        $config['middleware_pipeline'][] = $middleware;
                    }
                }

                if (isset($classAnnotations[Route::class])) {
                    /** @var Route $annotation */
                    $annotation = $classAnnotations[Route::class];
                    $route = [
                        'path' => $annotation->path,
                        'middleware' => $className,
                        'name' => !empty($annotation->name) ? $annotation->name : null,
                    ];

                    if (!empty($annotation->methods) && is_array($annotation->methods)) {
                        $route['allowed_methods'] = $annotation->methods;
                    }

                    if (!empty($annotation->options) && is_array($annotation->options)) {
                        $route['options'] = $annotation->options;
                    }

                    $config['routes'][] = $route;
                }

                $reflConstruct = $reflClass->getConstructor();
                if ($reflConstruct) {
                    /** @var Inject $constructAnnotation */
                    $constructAnnotation = $this->reader->getMethodAnnotation($reflConstruct, Inject::class);
                    if ($constructAnnotation) {
                        $name = $constructAnnotation->name() ?: $className;
                        $parameters = $constructAnnotation->parameters() ?: array_map(function (\ReflectionParameter $parameter) {
                            $class = $parameter->getClass();
                            if ($class === null) {
                                throw new InvalidArgumentException('You should inject an instance of class.');
                            }

                            return $parameter->getClass()->getName();
                        }, $reflConstruct->getParameters());
                        $factoryClassName = $this->factoryGenerator->generate($className, $parameters);
                        $config['dependencies']['factories'][$name] = $factoryClassName;
                    }
                }
            }
        }

        $config['routes'] = iterator_to_array($this->sortRoutes($config['routes']));

        return $config;
    }

    private function registerLoader()
    {
        /** @var ClassLoader $loader */
        if (file_exists(__DIR__ . '/../../../../../vendor/autoload.php')) {
            $loader = require __DIR__ . '/../../../../../vendor/autoload.php';
        } else {
            $loader = require __DIR__ . '/../../vendor/autoload.php';
        }

        AnnotationRegistry::registerLoader([$loader, 'loadClass']);

        $loader->addPsr4('Zelenin\\Zend\\Expressive\\Factories\\', $this->factoryPath);
    }

    private function sortRoutes(array $routes): \Traversable
    {
        $r = [];
        foreach ($routes as $route) {
            $pos = mb_strpos($route['path'], '{');
            if ($pos === false) {
                $r[$route['path']][] = $route;
            } else {
                $prefix = mb_substr($route['path'], 0, $pos);
                $r[$prefix][] = $route;
            }
        }

        uksort($r, function (string $a, string $b): bool {
            return mb_strlen($a) < mb_strlen($b);
        });

        foreach ($r as $groups) {
            usort($groups, function (array $a, array $b): bool {
                return mb_strlen($a['path']) < mb_strlen($b['path']);
            });
            foreach ($groups as $route) {
                yield $route;
            }
        }
    }
}
