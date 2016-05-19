<?php

namespace Zelenin\Zend\Expressive\Config\Provider;

use SplObjectStorage;
use Zelenin\Zend\Expressive\Config\Util\ArrayUtil;

final class CollectionProvider implements Provider
{
    /**
     * @var string
     */
    private $providers;

    /**
     * @param string $pattern
     */
    public function __construct(array $providers)
    {
        $this->providers = new SplObjectStorage();

        foreach ($providers as $provider) {
            $this->addProvider($provider);
        }
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        $config = [];
        foreach ($this->providers as $provider) {
            $config = ArrayUtil::merge($config, $provider->getConfig());
        }
        return $config;
    }

    /**
     * @param Provider $provider
     */
    public function addProvider(Provider $provider)
    {
        $this->providers->attach($provider);
    }
}
