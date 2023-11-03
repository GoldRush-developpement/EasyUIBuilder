<?php

namespace refaltor\ui\elements\utils;

use refaltor\ui\elements\Element;

class CloseButton extends Element implements  \JsonSerializable
{
    private string $defaultTextureButton = '';
    private string $hoverTextureButton = '';
    private string $pressedTextureButton = '';




    public function __construct(string $name)
    {
        $this->name = $name;

        parent::__construct($name, "common_dialogs.common_close_button_holder");
    }


    public static function create(string $name): self {
        return new self($name);
    }


    public function jsonSerialize()
    {
        $dataParent = parent::jsonSerialize();
        $propertiesExtra = $dataParent['properties_extra'];
        $controls = $this->controls;

        if (!is_null($this->extend)) {
            $name = $this->name . "@" . $this->extend;
        } else $name = $this->name;

        $element = [$name => [
            "default@common.close_button_panel" => [
                '$close_button_texture' => $this->defaultTextureButton
            ],
            "hover@common.close_button_panel" => [
                '$close_button_texture' => $this->hoverTextureButton
            ],
            "pressed@common.close_button_panel" => [
                '$close_button_texture' => $this->pressedTextureButton
            ],
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
    public function getDefaultTextureButton(): string
    {
        return $this->defaultTextureButton;
    }

    /**
     * @param string $defaultTextureButton
     */
    public function setDefaultTextureButton(string $defaultTextureButton): self
    {
        $this->defaultTextureButton = $defaultTextureButton;
        return $this;
    }

    /**
     * @return string
     */
    public function getHoverTextureButton(): string
    {
        return $this->hoverTextureButton;
    }

    /**
     * @param string $hoverTextureButton
     */
    public function setHoverTextureButton(string $hoverTextureButton): self
    {
        $this->hoverTextureButton = $hoverTextureButton;
        return $this;
    }

    /**
     * @return string
     */
    public function getPressedTextureButton(): string
    {
        return $this->pressedTextureButton;
    }

    /**
     * @param string $pressedTextureButton
     */
    public function setPressedTextureButton(string $pressedTextureButton): self
    {
        $this->pressedTextureButton = $pressedTextureButton;
        return $this;
    }

}