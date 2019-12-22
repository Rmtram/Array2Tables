<?php

namespace Rmtram\Array2Tables\Tables\Markdown;

use Rmtram\Array2Tables\Iterator;
use Rmtram\Array2Tables\Tables\TableInterface;

class Table implements TableInterface
{
    /**
     * @inheritDoc
     */
    public function create(array $headers, array $values): string
    {
        $h = $this->createHeader($headers);
        $b = $this->createBody($values);
        return implode(PHP_EOL, array_merge($h, $b));
    }

    /**
     * @inheritDoc
     */
    public function save(string $filePath, array $headers, array $values): bool
    {
        return false;
    }

    /**
     * @param array $headers
     * @return array
     */
    private function createHeader(array $headers): array
    {
        $mHeader = [];
        $mHeader[] = sprintf('|%s|', implode('|', $headers));
        $mHeader[] = sprintf('|%s|', implode('|', Iterator::times(count($headers), function () {
            return '---';
        })));
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
            $mBody[] = sprintf('|%s|', implode('|', $vs));
        }
        return $mBody;
    }
}
