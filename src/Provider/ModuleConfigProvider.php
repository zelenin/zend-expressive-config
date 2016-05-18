<?php

namespace Zelenin\Zend\Expressive\Config\Provider;

abstract class ModuleConfigProvider implements Provider
{
    /**
     * @return array
     */
    abstract public function getConfig();
}
