<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider;

interface Provider
{
    /**
     * @return array
     */
    public function getConfig(): array;
}
