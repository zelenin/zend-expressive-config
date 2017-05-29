<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Provider;

use FilesystemIterator;
use GlobIterator;
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
    public function __construct(string $pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @inheritdoc
     */
    public function getConfig(): array
    {
        $config = [];
        foreach (new GlobIterator($this->pattern, FilesystemIterator::SKIP_DOTS) as $file) {
            $config = ArrayUtil::merge($config, include $file->getRealPath());
        }

        return $config;
    }
}
