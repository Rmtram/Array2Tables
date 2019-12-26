<?php
declare(strict_types=1);

namespace Rmtram\Array2Tables\Tables\Html;

/**
 * Class Config
 * @package Rmtram\Array2Tables\Tables\Html
 */
class Config
{
    /**
     * @var array
     */
    private $attributes = [
        'table'   => [],
        'thead'   => [],
        'tbody'   => [],
        'th'      => [],
        'td'      => [],
        'caption' => [],
    ];

    /**
     * @var string|null
     */
    private $caption = null;

    /**
     * @var bool
     */
    private $escape = true;

    /**
     * Config constructor.
     *
     * @param array|null $options
     */
    public function __construct(?array $options = null)
    {
        if (isset($options['attributes'])) {
            $this->setAttributes($options['attributes']);
        }
        if (isset($options['caption'])) {
            $this->caption = $options['caption'];
        }
        if (isset($options['escape'])) {
            $this->escape = (bool)$options['escape'];
        }
    }

    /**
     * @param array $attributes
     * @return $this
     */
    public function setAttributes(array $attributes): self
    {
        $attributes = array_intersect_key($attributes, $this->attributes);
        $this->attributes = array_merge($this->attributes, $attributes);
        return $this;
    }

    /**
     * @param string|null $caption
     * @return $this
     */
    public function setCaption(?string $caption): self
    {
        $this->caption = $caption;
        return $this;
    }

    /**
     * @param bool $escape
     * @return $this
     */
    public function setEscape(bool $escape): self
    {
        $this->escape = $escape;
        return $this;
    }

    /**
     * @return array
     */
    public function getAttributes(): array
    {
        return $this->attributes;
    }

    /**
     * @param string $tagName
     * @return array|null
     */
    public function getAttribute(string $tagName): ?array
    {
        return $this->attributes[$tagName] ?? null;
    }

    /**
     * @return string|null
     */
    public function getCaption(): ?string
    {
        return $this->caption;
    }

    /**
     * @return bool
     */
    public function isEscape(): bool
    {
        return $this->escape;
    }
}
