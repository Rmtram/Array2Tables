<?php
declare(strict_types=1);

namespace Rmtram\Array2Tables\Tables;

/**
 * Interface TableInterface
 *
 * @package Rmtram\Array2Tables\Tables
 */
interface TableInterface
{
    /**
     * Create table string
     *
     * @param array $headers
     * @param array $values
     * @return string
     */
    public function create(array $headers, array $values): string;

    /**
     * Save table string
     *
     * @param string $filePath
     * @param array $headers
     * @param array $values
     * @return bool
     */
    public function save(string $filePath, array $headers, array $values): bool;
}
