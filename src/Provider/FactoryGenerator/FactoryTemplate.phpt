<?php
declare(strict_types=1);

namespace {{namespace}};

use Psr\Container\ContainerInterface;

final class {{factoryClassName}}
{
    /**
     * @param ContainerInterface $container
     *
     * @return {{serviceClassName}}
     */
    public function __invoke(ContainerInterface $container): {{serviceClassName}}
    {
        return new {{serviceClassName}}({{parameters}});
    }
}
