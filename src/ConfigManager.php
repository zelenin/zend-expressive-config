<?php

namespace Zelenin\Zend\Expressive\Config;

use Zelenin\Zend\Expressive\Config\Provider\CollectionProvider;
use Zelenin\Zend\Expressive\Config\Provider\Provider;

final class ConfigManager implements Provider
{
    /**
     * @var CollectionProvider
     */
    private $providers;

    /**
     * @param array $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = new CollectionProvider($providers);
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return $this->providers->getConfig();
    }

    /**
     * @param Provider $provider
     */
    public function addProvider(Provider $provider)
    {
        $this->providers->addProvider($provider);
    }
}
