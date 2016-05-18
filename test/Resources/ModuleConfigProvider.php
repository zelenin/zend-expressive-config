<?php

namespace Zend\Expressive\Config\Test\Resources;

final class ModuleConfigProvider extends \Zelenin\Zend\Expressive\Config\Provider\ModuleConfigProvider
{
    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        return [
            'bar' => 'foo'
        ];
    }
}
