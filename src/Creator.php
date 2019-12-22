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
        return new Output($table, $this->keys(), $this->items);
    }

    /**
     * @return Output
     */
    public function markdown(): Output
    {
        $table = new Tables\Markdown\Table();
        return new Output($table, $this->keys(), $this->items);
    }

    /**
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
