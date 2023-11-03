<?php

namespace refaltor\ui\elements;

use JsonSerializable;
use refaltor\ui\colors\BasicColor;

class Label extends Element implements JsonSerializable
{
    const FONT_SMALL = "small";
    const FONT_NORMAL = "normal";
    const FONT_LARGE = "large";
    const FONT_EXTRA_LARGE = "extra_large";

    const TYPE_DEFAULT = "default";
    const TYPE_RUNE = "rune";
    const TYPE_UNICODE = "unicode";
    const TYPE_SMOOTH = "smooth";
    const TYPE_MINECRAFT_TEN = "MinecraftTen";

    private string $text;
    private string $fontSize;
    private float $fontScaleFactor;
    private bool $shadow;
    private array $color;
    private string $fontType;

    public function __construct(
        string $name,
        string $text,
        ?string $extend = null,
        string $fontSize = self::FONT_NORMAL,
        float $fontScaleFactor = 1.0,
        string $fontType = self::TYPE_DEFAULT,
        bool $shadow = false,
        array $color = BasicColor::DEFAULT,
    )
    {
        $this->name = $name;
        $this->text = $text;
        $this->fontSize = $fontSize;
        $this->fontScaleFactor = $fontScaleFactor;
        $this->shadow = $shadow;
        $this->color = $color;
        $this->extend = $extend;
        $this->fontType = $fontType;


        parent::__construct($name, $extend);
    }

    // Getter and Setter for $text

    public static function create(string $name, string $text): self
    {
        return new self($name, $text);
    }

    public function getText(): string
    {
        return $this->text;
    }

    // Getter and Setter for $fontSize

    public function setText(string $text): Label
    {
        $this->text = $text;
        return $this;
    }

    public function getFontSize(): string
    {
        return $this->fontSize;
    }

    // Getter and Setter for $fontScaleFactor

    public function setFontSize(string $fontSize): Label
    {
        $this->fontSize = $fontSize;
        return $this;
    }

    public function getFontScaleFactor(): float
    {
        return $this->fontScaleFactor;
    }

    // Getter and Setter for $shadow

    public function setFontScaleFactor(float $fontScaleFactor): Label
    {
        $this->fontScaleFactor = $fontScaleFactor;
        return $this;
    }

    public function getShadow(): bool
    {
        return $this->shadow;
    }

    // Getter and Setter for $color

    public function setShadow(bool $shadow = true): Label
    {
        $this->shadow = $shadow;
        return $this;
    }

    public function getColor(): array
    {
        return $this->color;
    }

    public function setColor(array $color): Label
    {
        $this->color = $color;
        return $this;
    }

    public function jsonSerialize()
    {
        $dataParent = parent::jsonSerialize();
        $propertiesExtra = $dataParent['properties_extra'];
        $controls = $dataParent['controls'];

        if (!is_null($this->extend)) {
            $name = $this->name . "@" . $this->extend;
        } else $name = $this->name;


        $element = [$name => [
            "type" => "label",
            "text" => $this->text,
            "font_size" => $this->fontSize,
            "font_type" => $this->getFontType(),
            "font_scale_factor" => $this->fontScaleFactor,
            "shadow" => $this->shadow,
            "color" => $this->color,
        ]];


        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }



        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }

        return $element;
    }

    /**
     * @return string
     */
    public function getFontType(): string
    {
        return $this->fontType;
    }

    /**
     * @param string $fontType
     */
    public function setFontType(string $fontType): self
    {
        $this->fontType = $fontType;
        return $this;
    }
}