<?php

namespace Zelenin\Zend\Expressive\Config\Provider;

final class CacheProvider implements Provider
{
    /**
     * @var string
     */
    private $path;

    /**
     * @var CollectionProvider
     */
    private $providers;

    /**
     * @param string $path
     * @param array $providers
     */
    public function __construct($path, array $providers)
    {
        $this->path = $path;
        $this->providers = new CollectionProvider($providers);
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        if (!$this->isExist()) {
            file_put_contents($this->path, '<?php return ' . var_export($this->providers->getConfig(), true) . ';' . "\n");
        }
        return require_once $this->path;
    }

    /**
     * @return bool
     */
    private function isExist()
    {
        return is_file($this->path);
    }
}
