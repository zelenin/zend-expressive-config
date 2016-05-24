<?php

namespace Zelenin\Zend\Expressive\Config\Provider;

use FilesystemIterator;
use GlobIterator;
use SplFileInfo;
use Symfony\Component\Yaml\Parser;
use Zelenin\Zend\Expressive\Config\Util\ArrayUtil;

final class YamlProvider implements Provider
{
    /**
     * @var string
     */
    private $pattern;

    /**
     * @var Parser
     */
    private $parser;

    /**
     * @param string $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
        $this->parser = new Parser();
    }

    /**
     * @inheritdoc
     */
    public function getConfig()
    {
        $config = [];
        foreach ($this->iterate($this->pattern) as $file) {
            $config = ArrayUtil::merge($config, $this->parser->parse(file_get_contents($file->getRealPath())));
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
