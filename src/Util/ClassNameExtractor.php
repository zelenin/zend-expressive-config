<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Util;

final class ClassNameExtractor
{
    /**
     * @param string $content
     *
     * @return string
     */
    public function getClassName(string $content): string
    {
        $tokens = token_get_all($content);

        $namespaceCapturing = false;
        $classCapturing = false;

        $namespace = '';
        $className = '';

        foreach ($tokens as $token) {
            if ($token[0] == T_NAMESPACE) {
                $namespaceCapturing = true;
                continue;
            }

            if ($namespaceCapturing) {
                if (in_array($token[0], [T_STRING, T_NS_SEPARATOR], true)) {
                    $namespace .= $token[1];
                } else {
                    if ($namespace) {
                        $namespaceCapturing = false;
                    }
                }
            }

            if ($token[0] == T_CLASS) {
                $classCapturing = true;
                continue;
            }

            if ($classCapturing) {
                if ($token[0] === T_STRING) {
                    $className .= $token[1];
                } else {
                    if ($className || $token[0] !== T_WHITESPACE) {
                        break;
                    }
                }
            }
        }

        return $className ? sprintf("%s\%s", $namespace, $className) : '';
    }
}
