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
     * @var array
     */
    private $orders = [];

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
     * @param array $orders
     * @return $this
     */
    public function order(array $orders): self
    {
        $this->orders = $orders;
        return $this;
    }

    /**
     * @param Tables\Html\Config|null $config
     * @return Output
     */
    public function html(?Tables\Html\Config $config = null): Output
    {
        $table = new Tables\Html\Table($config);
        return new Output($table, ['hoge', 'fuga'], [[1, 2], [11, 22]]);
    }
}
