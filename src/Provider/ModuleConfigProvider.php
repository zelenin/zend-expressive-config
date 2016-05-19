<?php

namespace Zelenin\Zend\Expressive\Config\Provider;

abstract class ModuleConfigProvider implements Provider
{
    /**
     * @inheritdoc
     */
    abstract public function getConfig();
}
