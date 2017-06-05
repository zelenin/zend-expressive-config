<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider\FactoryGenerator;

final class FactoryGenerator
{
    /**
     * @var string
     */
    private $factoryPath;

    /**
     * @param string $factoryPath
     */
    public function __construct(string $factoryPath)
    {
        $this->factoryPath = $factoryPath;
    }

    /**
     * @param string $serviceClassName
     * @param array $parameters
     *
     * @return string
     */
    public function generate(string $serviceClassName, array $parameters): string
    {
        $template = file_get_contents(__DIR__ . '/FactoryTemplate.phpt');

        $serviceClassNameParts = explode('\\', $serviceClassName);
        $serviceShortClassName = array_pop($serviceClassNameParts);
        $factoryShortClassName = $serviceShortClassName . 'Factory';
        $factoryFilename = $factoryShortClassName . '.php';

        $factoryDirPath = str_replace('\\', DIRECTORY_SEPARATOR, $this->factoryPath . DIRECTORY_SEPARATOR . implode('\\', $serviceClassNameParts));
        if (!is_dir($factoryDirPath)) {
            mkdir($factoryDirPath, 0777, true);
        }

        $namespace = 'Zelenin\\Zend\\Expressive\\Factories\\' . implode('\\', $serviceClassNameParts);

        $serviceClassName = '\\' . $serviceClassName;

        $parameters = array_map(function (string $parameter) {
            if (in_array($parameter, [
                \Psr\Container\ContainerInterface::class,
                \Interop\Container\ContainerInterface::class,
            ], true)) {
                return '$container';
            }

            return sprintf('$container->get(\'%s\')', $parameter);
        }, $parameters);

        $factory = strtr($template, [
            '{{namespace}}' => $namespace,
            '{{factoryClassName}}' => $factoryShortClassName,
            '{{serviceClassName}}' => $serviceClassName,
            '{{parameters}}' => implode(', ', $parameters),
        ]);

        file_put_contents($factoryDirPath . DIRECTORY_SEPARATOR . $factoryFilename, $factory);

        return $namespace . '\\' . $factoryShortClassName;
    }
}
