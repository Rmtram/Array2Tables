<?php
declare(strict_types=1);

namespace Rmtram\Array2Tables;

use Rmtram\Array2Tables\Tables\TableInterface;

/**
 * Class Output
 * @package Rmtram\Array2Tables
 */
class Output
{
    /**
     * @var TableInterface
     */
    private $table;
    /**
     * @var array
     */
    private $headers;
    /**
     * @var array
     */
    private $values;

    /**
     * Output constructor.
     *
     * @param TableInterface $table
     * @param array $headers
     * @param array $values
     */
    public function __construct(TableInterface $table, array $headers, array $values)
    {
        $this->table = $table;
        $this->headers = $headers;
        $this->values = $values;
    }

    /**
     * @return string
     */
    public function render(): string
    {
        return $this->table->create($this->headers, $this->values);
    }

    /**
     * @param string $filePath
     * @return bool
     */
    public function save(string $filePath)
    {
        return $this->table->save($filePath, $this->headers, $this->values);
    }
}
