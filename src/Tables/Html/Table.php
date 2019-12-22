<?php
declare(strict_types=1);

namespace Rmtram\Array2Tables\Tables\Html;

use Rmtram\Array2Tables\Escape;
use Rmtram\Array2Tables\Tables\TableInterface;

/**
 * Class Table
 * @package Rmtram\Array2Tables\Tables\Html
 */
class Table implements TableInterface
{
    /**
     * @var Config
     */
    private $config;

    /**
     * Table constructor.
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
        return $this->doc($headers, $values)->saveHTML();
    }

    /**
     * @inheritDoc
     */
    public function save(string $filePath, array $headers, array $values): bool
    {
        return $this->doc($headers, $values)->saveHTMLFile($filePath) !== false;
    }

    /**
     * @param array $headers
     * @param array $values
     * @return \DOMDocument
     */
    private function doc(array $headers, array $values): \DOMDocument
    {
        $document = new \DOMDocument();
        $table = $this->createElement($document, 'table');
        $thead = $this->createHeader($document, $headers);
        $tbody = $this->createBody($document, $values);
        $caption = $this->createCaption($document);
        if ($caption !== null) {
            $table->appendChild($caption);
        }
        $table->appendChild($thead);
        $table->appendChild($tbody);
        $document->appendChild($table);
        return $document;
    }

    /**
     * @param \DOMDocument $document
     * @return \DOMElement|null
     */
    private function createCaption(\DOMDocument $document): ?\DOMElement
    {
        $caption = $this->config->getCaption();
        if ($caption === null) {
            return null;
        }
        return $this->createElement($document, 'caption', $this->h($caption));
    }

    /**
     * @param \DOMDocument $document
     * @param array $headers
     * @return \DOMElement
     */
    private function createHeader(\DOMDocument $document, array $headers): \DOMElement
    {
        $thead = $this->createElement($document, 'thead');
        foreach ($headers as $text) {
            $th = $this->createElement($document, isset($th) ? $th : 'th', $this->h($text));
            $thead->appendChild($th);
        }
        return $thead;
    }

    /**
     * @param \DOMDocument $document
     * @param array $values
     * @return \DOMElement
     */
    private function createBody(\DOMDocument $document, array $values): \DOMElement
    {
        $tbody = $this->createElement($document, 'thead');
        foreach ($values as $vs) {
            $tr = $this->createElement($document, 'tr');
            foreach ($vs as $text) {
                $td = $this->createElement($document, isset($td) ? $td : 'td', $this->h($text));
                $tr->appendChild($td);
            }
            $tbody->appendChild($tr);
        }
        return $tbody;
    }

    /**
     * @param \DOMDocument $document
     * @param \DOMElement|string $element
     * @param int|string|null $value
     * @return \DOMElement
     */
    private function createElement(\DOMDocument $document, $element, $value = null): \DOMElement
    {
        if ($element instanceof \DOMElement && $element->hasChildNodes() === false) {
            $element = clone $element;
        } else {
            $name = isset($element->nodeName) ? $element->nodeName : $element;
            $element = $document->createElement($name);
            $this->setAttributes($element);
        }
        if ($value !== null) {
            $element->nodeValue = $value;
        }
        return $element;
    }

    /**
     * @param \DOMElement $element
     */
    private function setAttributes(\DOMElement $element): void
    {
        $attribute = $this->config->getAttribute($element->nodeName);
        if (is_null($attribute)) {
            return;
        }
        foreach ($attribute as $name => $val) {
            if (is_array($val)) {
                $val = implode("\x20", $val);
            }
            $element->setAttribute($name, $this->h($val));
        }
    }

    /**
     * @param $string
     * @return string
     */
    private function h($string)
    {
        if ($this->config->getEscape()) {
            return Escape::h($string);
        }
        return $string;
    }
}
