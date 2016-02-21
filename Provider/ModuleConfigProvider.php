<?php

namespace Zelenin\Zend\Expressive\Config\Provider;

use Zelenin\Zend\Expressive\Config\Provider\Contract\Provider;

abstract class ModuleConfigProvider implements Provider
{
    /**
     * @return array
     */
    abstract public function getConfig();
}
