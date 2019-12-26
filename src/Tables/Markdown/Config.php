<?php
declare(strict_types=1);

namespace Rmtram\Array2Tables\Tables\Markdown;

/**
 * Class Config
 * @package Rmtram\Array2Tables\Tables\Markdown
 */
class Config
{
    /**
     * @var string
     */
    private $align = 'left';

    /**
     * @var array
     */
    private $attributesAlign = [];

    /**
     * @var boolean
     */
    private $escape = true;

    /**
     * Constructor
     *
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        if (empty($options)) {
            return;
        }
        if (isset($options['align'])) {
            $this->setAlign($options['align']);
        }
        if (isset($options['attributesAlign'])) {
            $this->setAttributesAlign($options['attributesAlign']);
        }
        if (isset($options['escape'])) {
            $this->setEscape($options['escape']);
        }
    }

    /**
     * @return string
     */
    public function getAlign(): string
    {
        return $this->align;
    }

    /**
     * @param string $align
     */
    public function setAlign(string $align): void
    {
        $this->align = $align;
    }

    /**
     * @param string $attribute
     * @return string
     */
    public function getAttributeAlign(string $attribute): ?string
    {
        return $this->attributesAlign[$attribute] ?? null;
    }

    /**
     * @param string $attribute
     * @param $align
     */
    public function setAttributeAlign(string $attribute, $align): void
    {
        $this->attributesAlign[$attribute] = $align;
    }

    /**
     * @return bool
     */
    public function isEscape(): bool
    {
        return $this->escape;
    }

    /**
     * @param bool $escape
     */
    public function setEscape(bool $escape): void
    {
        $this->escape = $escape;
    }

    /**
     * @param array $attributesAlign
     */
    public function setAttributesAlign(array $attributesAlign): void
    {
        $this->attributesAlign = $attributesAlign;
    }
}
