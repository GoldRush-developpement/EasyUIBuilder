<?php

namespace refaltor\ui\elements;

class EditBox extends Element implements \JsonSerializable
{
    private string $textBoxName = "";
    private string $placeHolderText = "";
    private string $placeHolderTextColor = "";
    private int $maxLength = 256;
    private bool $textBoxVisible = true;
    private bool $enabled = true;
    private string $textType = "ExtendedASCII";
    private string $textEditBoxGridCollectionName = "";
    private string $constrainedTextEditBox = "";
    private bool $virtual = false;
    private array $textColor = [1.0, 1.0, 1.0];
    private array $lockedColor = [0.5, 0.5, 0.5];

    const TEXT_TYPE_EXTENDED_ASCII = "ExtendedASCII";
    const TEXT_TYPE_IDENTIFIER_CHARS = "IdentifierChars";
    const TEXT_TYPE_NUMBER_CHARS = "NumberChars";

    public function __construct(string $name, ?string $extend = null)
    {
        $this->name = $name;
        $this->extend = $extend;
        parent::__construct($name, $extend);
    }

    public static function create(string $name): self
    {
        return new self($name);
    }

    public function setTextBoxName(string $name): self
    {
        $this->textBoxName = $name;
        return $this;
    }

    public function setPlaceHolderText(string $text): self
    {
        $this->placeHolderText = $text;
        return $this;
    }

    public function setPlaceHolderTextColor(string $color): self
    {
        $this->placeHolderTextColor = $color;
        return $this;
    }

    public function setMaxLength(int $length): self
    {
        $this->maxLength = $length;
        return $this;
    }

    public function setTextBoxVisible(bool $visible): self
    {
        $this->textBoxVisible = $visible;
        return $this;
    }

    public function setEnabled(bool $enabled): self
    {
        $this->enabled = $enabled;
        return $this;
    }

    public function setTextType(string $type): self
    {
        $this->textType = $type;
        return $this;
    }

    public function setTextEditBoxGridCollectionName(string $name): self
    {
        $this->textEditBoxGridCollectionName = $name;
        return $this;
    }

    public function setConstrainedTextEditBox(string $constraint): self
    {
        $this->constrainedTextEditBox = $constraint;
        return $this;
    }

    public function setVirtual(bool $virtual): self
    {
        $this->virtual = $virtual;
        return $this;
    }

    public function setTextColor(array $color): self
    {
        $this->textColor = $color;
        return $this;
    }

    public function setLockedColor(array $color): self
    {
        $this->lockedColor = $color;
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $dataParent = parent::jsonSerialize();
        $propertiesExtra = $dataParent['properties_extra'];
        $controls = $dataParent['controls'];

        if (!is_null($this->extend)) {
            $name = $this->name . "@" . $this->extend;
        } else $name = $this->name;

        $element = [$name => [
            "type" => "edit_box",
            "max_length" => $this->maxLength,
            "text_box_visible" => $this->textBoxVisible,
            "enabled_newline" => false,
            "text_type" => $this->textType,
            "text_color" => $this->textColor,
            "locked_color" => $this->lockedColor,
            "virtual" => $this->virtual,
        ]];

        if ($this->textBoxName !== '') $element[$name]["text_box_name"] = $this->textBoxName;
        if ($this->placeHolderText !== '') $element[$name]["place_holder_text"] = $this->placeHolderText;
        if ($this->placeHolderTextColor !== '') $element[$name]["place_holder_text_color"] = $this->placeHolderTextColor;
        if ($this->textEditBoxGridCollectionName !== '') $element[$name]["text_edit_box_grid_collection_name"] = $this->textEditBoxGridCollectionName;
        if ($this->constrainedTextEditBox !== '') $element[$name]["constrained_text_edit_box"] = $this->constrainedTextEditBox;

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }

        if (!empty($dataParent['bindings'])) {
            $element[$name]["bindings"] = $dataParent['bindings'];
        }
        if (!empty($dataParent['variables'])) {
            $element[$name]["variables"] = $dataParent['variables'];
        }
        if (!empty($dataParent['anims'])) {
            $element[$name]["anims"] = $dataParent['anims'];
        }
        if (!empty($dataParent['modifications'])) {
            $element[$name]["modifications"] = $dataParent['modifications'];
        }

        return $element;
    }
}
