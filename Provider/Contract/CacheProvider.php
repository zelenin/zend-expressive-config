<?php

namespace Zelenin\Zend\Expressive\Config\Provider\Contract;

interface CacheProvider extends Provider
{
    /**
     * @void
     */
    public function cacheConfig(array $config);

    /**
     * @return bool
     */
    public function isExist();
}
