<?php

namespace refaltor\ui\elements;

use refaltor\ui\builders\Root;

class Button extends Element implements  \JsonSerializable
{

    private string $buttonText = "";

    private string $defaultButtonTexture = "";
    private string $hoverButtonTexture = "";
    private string $pressedButtonTexture = "";
    private string $lockedButtonTexture = "";
    private string $titleConditionVisible = "";



    public function __construct(string $name, Root $root)
    {
        $this->name = $name;

        parent::__construct($name, $root->namespace . ".template_button_easy_ui_builder_stack_panel");
    }



    public static function create(string $name, Root $root): self {
        return new self($name, $root);
    }


    public function setVisibleIfTitle(string $buttonText): self {
        $this->titleConditionVisible = $buttonText;
        return $this;
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
            '$pressed_button_name' => "button.form_button_click",
            '$button_text' => $this->getButtonText(),
            '$button_text_binding_type' => 'collection',
            '$button_state_panel|default' => "common_buttons.new_ui_button_panel",
            '$button_text_grid_collection_name' => 'form_buttons',
            '$default_button_texture' => $this->defaultButtonTexture,
            '$hover_button_texture' => $this->hoverButtonTexture,
            '$pressed_button_texture' => $this->pressedButtonTexture,
            '$locked_button_texture' => $this->lockedButtonTexture,
            '$focus_enabled' => false,
            '$focus_wrap_enabled' => false,
            '$condition' => "(#form_button_text = '".$this->titleConditionVisible."')"
        ]];

        foreach ($propertiesExtra as $propertyName => $property) {
            if ($propertyName === "size") {
                $element[$name]['$size'] = $property;
            } else $element[$name][$propertyName] = $property;
        }



        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }
        return $element;
    }

    /**
     * @return string
     */
    public function getButtonText(): string
    {
        return $this->buttonText;
    }

    /**
     * @param string $buttonText
     */
    public function setButtonText(string $buttonText): self
    {
        $this->buttonText = $buttonText;
        return $this;
    }

    /**
     * @return string
     */
    public function getDefaultButtonTexture(): string
    {
        return $this->defaultButtonTexture;
    }

    /**
     * @param string $defaultButtonTexture
     */
    public function setDefaultButtonTexture(string $defaultButtonTexture): self
    {
        $this->defaultButtonTexture = $defaultButtonTexture;
        return $this;
    }

    /**
     * @return string
     */
    public function getHoverButtonTexture(): string
    {
        return $this->hoverButtonTexture;
    }

    /**
     * @param string $hoverButtonTexture
     */
    public function setHoverButtonTexture(string $hoverButtonTexture): self
    {
        $this->hoverButtonTexture = $hoverButtonTexture;
        return $this;
    }

    /**
     * @return string
     */
    public function getPressedButtonTexture(): string
    {
        return $this->pressedButtonTexture;
    }

    /**
     * @param string $pressedButtonTexture
     */
    public function setPressedButtonTexture(string $pressedButtonTexture): self
    {
        $this->pressedButtonTexture = $pressedButtonTexture;
        return $this;
    }

    /**
     * @return string
     */
    public function getLockedButtonTexture(): string
    {
        return $this->lockedButtonTexture;
    }

    /**
     * @param string $lockedButtonTexture
     */
    public function setLockedButtonTexture(string $lockedButtonTexture): self
    {
        $this->lockedButtonTexture = $lockedButtonTexture;
        return $this;
    }
}