<?php

namespace refaltor\ui\elements\utils;

use refaltor\ui\elements\Element;

class PlayerRender extends Element implements  \JsonSerializable
{
    public function __construct(string $name)
    {
        $this->name = $name;
        parent::__construct($name, "start.skin_viewer_panel");
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

        ]];

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }
        return $element;
    }
}