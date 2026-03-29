<?php

namespace refaltor\ui\elements;

class Dropdown extends Element implements \JsonSerializable
{
    private string $dropdownName = "";
    private string $dropdownContentControl = "";
    private string $dropdownArea = "";
    private string $dropdownScrollContentPanel = "";
    private array $dropdownItems = [];

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

    public function setDropdownName(string $name): self
    {
        $this->dropdownName = $name;
        return $this;
    }

    public function setDropdownContentControl(string $control): self
    {
        $this->dropdownContentControl = $control;
        return $this;
    }

    public function setDropdownArea(string $area): self
    {
        $this->dropdownArea = $area;
        return $this;
    }

    public function setDropdownScrollContentPanel(string $panel): self
    {
        $this->dropdownScrollContentPanel = $panel;
        return $this;
    }

    public function addDropdownItem(string $label, string $value): self
    {
        $this->dropdownItems[] = ['label' => $label, 'value' => $value];
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
            "type" => "dropdown",
        ]];

        if ($this->dropdownName !== '') $element[$name]["dropdown_name"] = $this->dropdownName;
        if ($this->dropdownContentControl !== '') $element[$name]["dropdown_content_control"] = $this->dropdownContentControl;
        if ($this->dropdownArea !== '') $element[$name]["dropdown_area"] = $this->dropdownArea;
        if ($this->dropdownScrollContentPanel !== '') $element[$name]["dropdown_scroll_content_panel"] = $this->dropdownScrollContentPanel;

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }

        return $element;
    }
}
