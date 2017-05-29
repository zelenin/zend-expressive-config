<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider;

final class ArrayProvider implements Provider
{
    /**
     * @var array
     */
    private $array;

    /**
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @inheritdoc
     */
    public function getConfig(): array
    {
        return $this->array;
    }
}
