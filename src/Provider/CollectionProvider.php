<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider;

use Zelenin\Zend\Expressive\Config\Util\ArrayUtil;

final class CollectionProvider implements Provider
{
    /**
     * @var Provider[]
     */
    private $providers;

    /**
     * @param Provider[] $providers
     */
    public function __construct(array $providers)
    {
        $this->providers = [];
        array_walk($providers, function (Provider $provider) {
            $this->providers[] = $provider;
        });
    }

    /**
     * @inheritdoc
     */
    public function getConfig(): array
    {
        $config = [];
        foreach ($this->providers as $provider) {
            $config = ArrayUtil::merge($config, $provider->getConfig());
        }

        return $config;
    }
}
