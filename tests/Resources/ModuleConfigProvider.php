<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test\Resources;

final class ModuleConfigProvider extends \Zelenin\Zend\Expressive\Config\Provider\ModuleConfigProvider
{
    /**
     * @inheritdoc
     */
    public function getConfig(): array
    {
        return [
            'bar' => 'foo',
        ];
    }
}
