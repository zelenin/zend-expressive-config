<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test\Resources;

use Zelenin\Zend\Expressive\Config\Provider\Annotation\Invokable;

/**
 * @Invokable(id=InvokableWithAnnotation::class)
 */
final class InvokableWithAnnotation
{
    public function __invoke()
    {
    }
}
