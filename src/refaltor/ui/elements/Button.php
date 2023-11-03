<?php

namespace refaltor\ui\elements;

class Button extends Element implements  \JsonSerializable
{

    private string $buttonText = "";

    private string $defaultButtonTexture = "";
    private string $hoverButtonTexture = "";
    private string $pressedButtonTexture = "";
    private string $lockedButtonTexture = "";



    public function __construct(string $name)
    {
        $this->name = $name;

        parent::__construct($name, "common_buttons.light_text_button");
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
            '$pressed_button_name' => "button.form_button_click",
            '$button_text' => $this->getButtonText(),
            '$button_text_binding_type' => 'collection',
            '$button_state_panel|default' => "common_buttons.new_ui_button_panel",
            '$button_text_grid_collection_name' => 'form_buttons',
            'bindings' => [
                [
                    'binding_type' => 'collection_details',
                    'binding_collection_name' => 'form_buttons'
                ],
                [
                    'binding_name' => '#form_button_text',
                    'binding_type' => 'collection',
                    'binding_collection_name' => 'form_buttons'
                ],
                [
                    'binding_type' => 'view',
                    'source_property_name' => '$condition',
                    'target_property_name' => '#visible'
                ]
            ]


        ]];

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }


        $element[$name]["controls"] = [
            'default@$default_state_panel' => [
                '$new_ui_button_texture' => $this->defaultButtonTexture,
                '$default_state' => true
            ],
            'hover@$default_state_panel' => [
                '$new_ui_button_texture' => $this->hoverButtonTexture,
                '$hover_state' => true
            ],
            'pressed@$default_state_panel' => [
                '$new_ui_button_texture' => $this->pressedButtonTexture,
                '$pressed_state' => true
            ],
            'locked@$default_state_panel' => [
                '$new_ui_button_texture' => $this->lockedButtonTexture,
                '$locked_state' => true
            ]
        ];

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