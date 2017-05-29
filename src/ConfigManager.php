<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config;

use Zelenin\Zend\Expressive\Config\Provider\CollectionProvider;
use Zelenin\Zend\Expressive\Config\Provider\Provider;

final class ConfigManager implements Provider
{
    /**
     * @var CollectionProvider
     */
    private $provider;

    /**
     * @param Provider[] $providers
     */
    public function __construct(array $providers)
    {
        $this->provider = new CollectionProvider($providers);
    }

    /**
     * @return array
     */
    public function getConfig(): array
    {
        return $this->provider->getConfig();
    }
}
