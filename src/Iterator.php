<?php
declare(strict_types=1);

namespace Rmtram\Array2Tables;

/**
 * Class Iterator
 * @package Rmtram\Array2Tables
 */
class Iterator
{
    public static function times(int $num, callable $callback): array
    {
        $ret = [];
        for ($i = 0; $i < $num; $i++) {
            $ret[] = $callback($i);
        }
        return $ret;
    }
}
