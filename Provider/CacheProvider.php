<?php

namespace Zelenin\Zend\Expressive\Config\Provider;

final class CacheProvider implements \Zelenin\Zend\Expressive\Config\Provider\Contract\CacheProvider
{
    /**
     * @var string
     */
    private $path;

    /**
     * @param string $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * @param array $config
     */
    public function cacheConfig(array $config)
    {
        file_put_contents($this->path, '<?php return ' . var_export($config, true) . ';');
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return require_once $this->path;
    }

    /**
     * @return bool
     */
    public function isExist()
    {
        return is_file($this->path);
    }
}
