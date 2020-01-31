<?php
declare(strict_types=1);

namespace Rmtram\Array2Tables;

/**
 * Class Creator
 * @package Rmtram\Array2Tables
 */
class Creator
{
    /**
     * @var array
     */
    private $items;

    /**
     * @param array $items
     * @return static
     */
    public static function make(array $items): self
    {
        return new self($items);
    }

    /**
     * Creator constructor.
     *
     * @param array $items
     */
    private function __construct(array $items)
    {
        $this->items = $items;
    }

    /**
     * @param Tables\Html\Config|null $config
     * @return Output
     */
    public function html(?Tables\Html\Config $config = null): Output
    {
        $table = new Tables\Html\Table($config);
        return $this->out($table);
    }

    /**
     * @param Tables\Markdown\Config|null $config
     * @return Output
     */
    public function markdown(?Tables\Markdown\Config $config = null): Output
    {
        $table = new Tables\Markdown\Table($config);
        return $this->out($table);
    }

    /**
     * @return Output
     */
    public function ascii(): Output
    {
        $table = new Tables\Ascii\Table();
        return $this->out($table);
    }

    /**
     * @param Tables\TableInterface $table
     * @return Output
     */
    private function out(Tables\TableInterface $table): Output
    {
        return new Output($table, $this->keys(), $this->items);
    }

    /**
     * Get item keys.
     *
     * @return array
     */
    private function keys(): array
    {
        if (empty($this->items)) {
            return [];
        }
        return array_keys(current($this->items));
    }
}
