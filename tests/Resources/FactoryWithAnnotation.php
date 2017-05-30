<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test\Resources;

use Zelenin\Zend\Expressive\Config\Provider\Annotation\Factory;

/**
 * @Factory(id="serviceId")
 */
final class FactoryWithAnnotation
{
    public function __invoke()
    {
    }
}
