<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
final class Middleware
{
    /**
     * @Required
     *
     * @var string
     */
    public $path;

    /**
     * @var int
     */
    public $priority;

    /**
     * @var string
     */
    public $name;
}
