<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider;

abstract class ModuleConfigProvider implements Provider
{
    /**
     * @inheritdoc
     */
    abstract public function getConfig(): array;
}
