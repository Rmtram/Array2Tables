<?php
declare(strict_types=1);

namespace Rmtram\Array2Tables\Tables\Ascii;

use Rmtram\Array2Tables\Tables\TableInterface;

class Table implements TableInterface
{
    const CHAR_SYMBOL = '+';
    const CHAR_LINE = '-';
    const CHAR_PAD = "\x20";
    const CHAR_SEP = '|';
    const DEFAULT_PAD_SIZE = 2;
    const EOL = PHP_EOL;

    /**
     * Create table string
     *
     * @param array $headers
     * @param array $values
     *
     * @return string
     */
    public function create(array $headers, array $values): string
    {
        $columnsLength = $this->maxColumnsLength($headers, $values);
        $header = $this->createHeader($headers, $columnsLength);
        $body = $this->createBody($values, $columnsLength);
        return $header . $body;
    }

    /**
     * Save table string
     *
     * @param string $filePath
     * @param array $headers
     * @param array $values
     *
     * @return bool
     */
    public function save(string $filePath, array $headers, array $values): bool
    {
        $ascii = $this->create($headers, $values);
        return (bool)file_put_contents($filePath, $ascii);
    }
    
    /**
     * @param array $keys
     * @return string
     */
    private function createHeader(array $headers, array $columnsLength): string
    {
        $borderLine = '';
        $valueLine = '';
        foreach ($headers as $key) {
            [$bl, $vl] = $this->createColumnLine($key, $key, $columnsLength[$key]);
            $borderLine .= $bl;
            $valueLine .= $vl;
        }
        return sprintf(
            "%s%s%s%s%s%s%s%s%s",
            $borderLine,
            self::CHAR_SYMBOL,
            self::EOL,
            $valueLine,
            self::CHAR_SEP,
            self::EOL,
            $borderLine,
            self::CHAR_SYMBOL,
            self::EOL
        );
    }

    /**
     * @param array $values
     * @param array $columnsLength
     * @return string
     */
    private function createBody(array $values, array $columnsLength): string
    {
        $lines = '';
        foreach ($values as $val) {
            $borderLine = '';
            $valueLine = '';
            foreach ($val as $key => $v) {
                if (!isset($columnsLength[$key])) {
                    continue;
                }
                [$bl, $vl] = $this->createColumnLine($key, $v, $columnsLength[$key]);
                $borderLine .= $bl;
                $valueLine .= $vl;
            }
            $lines .= sprintf(
                "%s%s%s%s%s%s",
                $valueLine,
                self::CHAR_SEP,
                self::EOL,
                $borderLine,
                self::CHAR_SYMBOL,
                self::EOL
            );
        }
        return $lines;
    }

    /**
     * @param string $key
     * @param int|string $val
     * @param integer $columnLength
     * @return array
     */
    private function createColumnLine(string $key, $val, int $columnLength): array
    {
        $len = $this->len($val);
        $line = str_repeat(self::CHAR_LINE, $columnLength);
        $lp = (int)($columnLength / 2) - (int)($len / 2);
        $rp = $len %2 !== 0 ? $lp : $lp + 1;
        $borderLine = sprintf('%s%s', self::CHAR_SYMBOL, $line);
        $valueLine = sprintf(
            "%s%s%s%s",
            self::CHAR_SEP,
            str_repeat(self::CHAR_PAD, $lp),
            $val,
            str_repeat(self::CHAR_PAD, $rp)
        );
        return [$borderLine, $valueLine];
    }

    /**
     * @param array $headers
     * @param array $values
     * @return array
     */
    private function maxColumnsLength(array $headers, array $values): array
    {
        $hLength = array_map([$this, 'len'], $headers);
        $vLength = array_map(function ($key) use ($values) {
            if (empty($values)) {
                return 0;
            }
            $columnValues = array_column($values, $key);
            if (empty($columnValues)) {
                return 0;
            }
            return max(array_map([$this, 'len'], $columnValues));
        }, $headers);
        $ret = [];
        foreach ($hLength as $index => $len) {
            $ret[$headers[$index]] = max($len, $vLength[$index]) + self::DEFAULT_PAD_SIZE;
        }
        return $ret;
    }

    /**
     * @param string $text
     * @return integer
     */
    private function len($text): int
    {
        if (empty($text)) {
            return 0;
        }
        if (function_exists('mb_convert_encoding')) {
            return strlen(mb_convert_encoding((string)$text, 'Shift-JIS', 'UTF-8'));
        }
        return strlen($text);
    }
}
