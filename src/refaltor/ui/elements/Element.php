<?php

namespace refaltor\ui\elements;

use refaltor\ui\builders\Root;

class Element implements \JsonSerializable
{
    public array $properties = [];
    public array $controls = [];

    const ANCHOR_TOP_LEFT = 'top_left';
    const ANCHOR_TOP_MIDDLE = 'top_middle';
    const ANCHOR_TOP_RIGHT = 'top_right';
    const ANCHOR_LEFT_MIDDLE = 'left_middle';
    const ANCHOR_CENTER = 'center';
    const ANCHOR_RIGHT_MIDDLE = 'right_middle';
    const ANCHOR_BOTTOM_LEFT = 'bottom_left';
    const ANCHOR_BOTTOM_MIDDLE = 'bottom_middle';
    const ANCHOR_BOTTOM_RIGHT = 'bottom_right';


    public function __construct(
        public string $name,
        public ?string $extend = null)
    {}

    public function setOffset(float $x, float $y): self {
        $this->properties['offset'] = [$x, $y];
        return $this;
    }

    public function setLayer(int $layer): self {
        $this->properties['layer'] = $layer;
        return $this;
    }

    public function setAlpha(float $alpha): self {
        $this->properties['alpha'] = $alpha;
        return $this;
    }

    public function setSize(int $x, int $z): self {
        $this->properties['size'] = [$x, $z];
        return $this;
    }

    public function setSizePercentage(int $percentageX, int $percentageZ): self {
        $this->properties['size'] = ["$percentageX%", "$percentageZ%"];
        return $this;
    }

    public function enableFactoryButton(Root $root): self {
        $root->elements["template_button_easy_ui_builder@common_buttons.light_text_button"] = [
            "pressed_button_name" => "button.form_button_click",
            '$size|default' => ['100%', '100%'],
            "size" => '$size',
            '$condition|default' => true,
            '$button_text' => '',
            "button_text" => '$button_text',
            "button_text_binding_type" => "collection",
            "button_text_grid_collection_name" => "form_buttons",
            "button_text_max_size" => [ "100%", 20 ],
            '$border_visible' => false,
            "bindings" => [
                [
                    "binding_type" => "collection_details",
                    "binding_collection_name" => "form_buttons"
                ],
                [
                    "binding_name" => "#form_button_text",
                    "binding_type" => "collection",
                    "binding_collection_name" => "form_buttons"
                ],
                [
                    "binding_type" => "view",
                    "source_property_name" => '$condition',
                    "target_property_name" => "#visible"
                ]
            ]
        ];

        $root->elements['template_button_easy_ui_builder_stack_panel'] = [
            "type" => "stack_panel",
            "orientation" => "horizontal",
            "factory" => [
                'name' => "buttons",
                'control_name' => $root->namespace . ".template_button_easy_ui_builder"
            ],
            "collection_name" => "form_buttons",
            "bindings" => [
                [
                    "binding_name" => "#form_button_length",
                    "binding_name_override" => "#collection_length"
                ]
            ]
        ];


        return $this;
    }

    public function setSizePixel(int $pixelX, int $pixelZ): self {
        $this->properties['size'] = ["$pixelX" . "px", "$pixelX" . "px"];
        return $this;
    }


    public function setCustomSize(array $size): self {
        $this->properties['size'] = $size;
        return $this;
    }

    public function setAnchorFrom(string $anchorFrom): self {
        $this->properties["anchor_from"] = $anchorFrom;
        return $this;
    }

    public function setAnchorTo(string $anchorTo): self {
        $this->properties["anchor_to"] = $anchorTo;
        return $this;
    }

    public function addChild(Element $element): self {
        $this->controls[] = $element;
        return $this;
    }

    public function addChilds(array $elements): self {
        foreach ($elements as $element) {
            $this->controls[] = $element;
        }
        return $this;
    }

    public function jsonSerialize()
    {
        return [
            'properties_extra' => $this->properties,
            'controls' => $this->controls
        ];
    }

    /**
     * @return string|null
     */
    public function getExtend(): ?string
    {
        return $this->extend;
    }

    /**
     * @param string|null $extend
     */
    public function setExtend(?string $extend): void
    {
        $this->extend = $extend;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }
}