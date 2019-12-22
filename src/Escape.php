<?php
declare(strict_types=1);

namespace Rmtram\Array2Tables;

/**
 * Class Escape
 * @package Rmtram\Array2Tables
 */
class Escape
{
    /**
     * @param $string
     * @return string
     */
    public static function h($string)
    {
        if (!is_string($string)) {
            return $string;
        }
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    /**
     * @param $string
     * @return string
     */
    public static function d($string)
    {
        if (!is_string($string)) {
            return $string;
        }
        return htmlspecialchars_decode($string);
    }
}
