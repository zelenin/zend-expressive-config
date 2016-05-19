<?php

namespace Zelenin\Zend\Expressive\Config\Provider;

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
        foreach ($this->glob($this->pattern) as $file) {
            $config = ArrayUtil::merge($config, $this->parser->parse(file_get_contents($file)));
        }
        return $config;
    }

    /**
     * @param string $pattern
     *
     * @return array
     */
    private function glob($pattern)
    {
        return glob($pattern, GLOB_BRACE);
    }
}
