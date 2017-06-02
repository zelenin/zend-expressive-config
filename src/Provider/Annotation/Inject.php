<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider\Annotation;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
final class Inject
{
    /**
     * @var string
     */
    private $name;

    /**
     * @var array
     */
    private $parameters;

    /**
     * @param $values
     */
    public function __construct(array $values)
    {
        $this->name = isset($values['name']) ? $values['name'] : '';
        $this->parameters = isset($values['parameters']) ? $values['parameters'] : [];
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function parameters(): array
    {
        return $this->parameters;
    }
}
