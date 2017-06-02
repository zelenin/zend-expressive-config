<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test\Resources;

use Zelenin\Zend\Expressive\Config\Provider\Annotation\Inject;
use Zelenin\Zend\Expressive\Config\Provider\ArrayProvider;

final class ServiceWithAnnotation
{
    /**
     * @var ArrayProvider
     */
    private $dependency;

    /**
     * @Inject
     *
     * @param ArrayProvider $dependency
     */
    public function __construct(ArrayProvider $dependency)
    {
        $this->dependency = $dependency;
    }
}
