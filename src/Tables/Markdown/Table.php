<?php
declare(strict_types=1);

namespace Rmtram\Array2Tables\Tables\Markdown;

use Rmtram\Array2Tables\Escape;
use Rmtram\Array2Tables\Tables\TableInterface;

/**
 * Class Table
 * @package Rmtram\Array2Tables\Tables\Markdown
 */
class Table implements TableInterface
{
    const ALIGNS = [
        'left'   => '---',
        'right'  => '--:',
        'center' => ':-:'
    ];
    /**
     * @var Config
     */
    private $config;

    /**
     * Constructor
     *
     * @param Config|null $config
     */
    public function __construct(?Config $config = null)
    {
        $this->config = $config ?? new Config();
    }

    /**
     * @inheritDoc
     */
    public function create(array $headers, array $values): string
    {
        $md = [];
        $md[] = $this->createHeader($headers);
        $md[] = $this->createBody($values);
        return implode(PHP_EOL, array_merge(...$md));
    }

    /**
     * @inheritDoc
     */
    public function save(string $filePath, array $headers, array $values): bool
    {
        return (bool)file_put_contents($filePath, $this->create($headers, $values));
    }

    /**
     * @param array $headers
     * @return array
     */
    private function createHeader(array $headers): array
    {
        $mHeader = [];
        $mHeader[] = $this->createLine($headers);
        $mHeader[] = $this->createAlignLine($headers);
        return $mHeader;
    }

    /**
     * @param array $values
     * @return array
     */
    private function createBody(array $values): array
    {
        $mBody = [];
        foreach ($values as $vs) {
            $mBody[] = $this->createLine($vs);
        }
        return $mBody;
    }

    /**
     * @param array $v
     * @return string
     */
    private function createLine(array $v): string
    {
        return sprintf('|%s|', implode('|', $this->escape($v)));
    }

    /**
     * @param array $headers
     * @return string
     */
    private function createAlignLine(array $headers): string
    {
        $align = self::ALIGNS[$this->config->getAlign()] ?? self::ALIGNS['left'];
        return sprintf('|%s|', implode('|', array_map(function ($attribute) use ($align) {
            $aAlign = $this->config->getAttributeAlign($attribute);
            return $aAlign !== null && isset(self::ALIGNS[$aAlign]) ? self::ALIGNS[$aAlign] : $align;
        }, $headers)));
    }

    /**
     * Escape value.
     *
     * @param mixed $val
     * @return mixed
     */
    private function escape($val)
    {
        if ($val === null || $this->config->isEscape() === false) {
            return $val;
        }
        if (is_array($val)) {
            return array_map([Escape::class, 'h'], $val);
        }
        return Escape::h($val);
    }
}
