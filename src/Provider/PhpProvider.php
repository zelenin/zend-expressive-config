<?php

namespace Zelenin\Zend\Expressive\Config\Provider;

use FilesystemIterator;
use GlobIterator;
use SplFileInfo;
use Zelenin\Zend\Expressive\Config\Util\ArrayUtil;

final class PhpProvider implements Provider
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        $config = [];
        foreach ($this->iterate($this->pattern) as $file) {
            $config = ArrayUtil::merge($config, include $file->getRealPath());
        }
        return $config;
    }

    /**
     * @param $pattern
     *
     * @return GlobIterator|SplFileInfo[]
     */
    private function iterate($pattern)
    {
        return new GlobIterator($this->pattern, FilesystemIterator::SKIP_DOTS);
    }
}
