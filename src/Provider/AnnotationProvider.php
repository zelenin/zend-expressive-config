<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider;

use Doctrine\Common\Annotations\AnnotationReader;
use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\IndexedReader;
use Doctrine\Common\Annotations\Reader;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use RecursiveRegexIterator;
use ReflectionClass;
use RegexIterator;
use Zelenin\Zend\Expressive\Config\Provider\Annotation\Factory;
use Zelenin\Zend\Expressive\Config\Provider\Annotation\Invokable;
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
     * @var ClassNameExtractor
     */
    private $classNameExtractor;

    public function __construct(string $path)
    {
        $this->reader = new IndexedReader(new AnnotationReader());
        $this->path = $path;
        $this->classNameExtractor = new ClassNameExtractor();

        AnnotationRegistry::registerFile(__DIR__ . '/Annotation/Factory.php');
        AnnotationRegistry::registerFile(__DIR__ . '/Annotation/Invokable.php');
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
                    $config['dependencies']['invokables'][$annotation->id] = $className;
                }
            }
        }

        return $config;
    }
}