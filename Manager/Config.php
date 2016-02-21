<?php

namespace Zelenin\Zend\Expressive\Config\Manager;

use Zelenin\Zend\Expressive\Config\Provider\Contract\CacheProvider;
use Zelenin\Zend\Expressive\Config\Provider\Contract\Provider;
use Zelenin\Zend\Expressive\Config\Util\ArrayUtil;

final class Config implements Provider
{
    /**
     * @var Provider[]
     */
    private $providers;

    /**
     * @var CacheProvider|null
     */
    private $cacheProvider;

    /**
     * @param Provider[] $providers
     * @param CacheProvider|null $cacheProvider
     */
    public function __construct($providers, CacheProvider $cacheProvider = null)
    {
        $this->providers = $providers;
        $this->cacheProvider = $cacheProvider;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        if ($this->cacheProvider) {
            if (!$this->cacheProvider->isExist()) {
                $this->cacheProvider->cacheConfig($this->getConfigFromProviders());
            }
            return $this->cacheProvider->getConfig();
        }
        return $this->getConfigFromProviders();
    }

    /**
     * @return array
     */
    private function getConfigFromProviders()
    {
        $config = [];
        foreach ($this->providers as $provider) {
            $config = ArrayUtil::merge($config, $provider->getConfig());
        }
        return $config;
    }
}
