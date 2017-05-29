<?php
declare(strict_types=1);

namespace Zelenin\Zend\Expressive\Config\Util;

final class ArrayUtil
{
    /**
     * @param array $a
     * @param array $b
     *
     * @return array
     */
    public static function merge(array $a, array $b): array
    {
        foreach ($b as $key => $value) {
            if (array_key_exists($key, $a)) {
                if (is_int($key)) {
                    $a[] = $value;
                } elseif (is_array($value) && is_array($a[$key])) {
                    $a[$key] = static::merge($a[$key], $value);
                } else {
                    $a[$key] = $value;
                }
            } else {
                $a[$key] = $value;
            }
        }

        return $a;
    }
}
