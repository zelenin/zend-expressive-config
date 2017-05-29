<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Test;

use PHPUnit\Framework\TestCase;
use Zelenin\Zend\Expressive\Config\Util\ArrayUtil;

final class ArrayUtilMergeTest extends TestCase
{
    public function testConfig()
    {
        $config1 = [
            'foo' => [
                'bar' => 'baz',
            ],
            'baz' => 'foo',
        ];

        $config2 = [
            'foo' => [
                'bar' => 'foo',
            ],
        ];

        $testConfig = [
            'foo' => [
                'bar' => 'foo',
            ],
            'baz' => 'foo',
        ];

        $this->assertEquals($testConfig, ArrayUtil::merge($config1, $config2));
    }
}
