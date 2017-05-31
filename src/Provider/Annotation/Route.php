<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
final class Route
{
    /**
     * @Required
     *
     * @var string
     */
    public $path;

    /**
     * @var array
     */
    public $methods;

    /**
     * @var string
     */
    public $name;

    /**
     * @var array
     */
    public $options;
}
