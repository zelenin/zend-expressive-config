<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider\Annotation;

/**
 * @Annotation
 * @Target({"CLASS"})
 */
final class Factory
{
    /**
     * @Required
     *
     * @var string
     */
    public $id;
}
