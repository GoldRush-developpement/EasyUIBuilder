<?php

namespace refaltor\ui\elements;

class Toggle extends Element implements \JsonSerializable
{
    private bool $toggleDefaultState = false;
    private string $toggleName = "";
    private string $toggleGroupDefaultTab = "";
    private string $toggleGroupForcedIndex = "";
    private bool $resetOnFocusLost = false;
    private string $toggleOnButton = "button.menu_select";
    private string $toggleOffButton = "button.menu_select";
    private bool $enableDirectionalToggling = true;
    private string $radioToggleGroup = "";
    private int $toggleTabIndex = 0;
    private string $checkedControl = "";
    private string $uncheckedControl = "";
    private string $checkedHoverControl = "";
    private string $uncheckedHoverControl = "";
    private string $checkedLockedControl = "";
    private string $uncheckedLockedControl = "";
    private string $checkedLockedHoverControl = "";
    private string $uncheckedLockedHoverControl = "";
    private string $soundName = "random.click";
    private float $soundVolume = 1.0;
    private float $soundPitch = 1.0;

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

    public function setToggleDefaultState(bool $state): self
    {
        $this->toggleDefaultState = $state;
        return $this;
    }

    public function setToggleName(string $name): self
    {
        $this->toggleName = $name;
        return $this;
    }

    public function setToggleGroupDefaultTab(string $tab): self
    {
        $this->toggleGroupDefaultTab = $tab;
        return $this;
    }

    public function setToggleGroupForcedIndex(string $index): self
    {
        $this->toggleGroupForcedIndex = $index;
        return $this;
    }

    public function setResetOnFocusLost(bool $reset): self
    {
        $this->resetOnFocusLost = $reset;
        return $this;
    }

    public function setToggleOnButton(string $button): self
    {
        $this->toggleOnButton = $button;
        return $this;
    }

    public function setToggleOffButton(string $button): self
    {
        $this->toggleOffButton = $button;
        return $this;
    }

    public function setEnableDirectionalToggling(bool $enable): self
    {
        $this->enableDirectionalToggling = $enable;
        return $this;
    }

    public function setRadioToggleGroup(string $group): self
    {
        $this->radioToggleGroup = $group;
        return $this;
    }

    public function setToggleTabIndex(int $index): self
    {
        $this->toggleTabIndex = $index;
        return $this;
    }

    public function setCheckedControl(string $control): self
    {
        $this->checkedControl = $control;
        return $this;
    }

    public function setUncheckedControl(string $control): self
    {
        $this->uncheckedControl = $control;
        return $this;
    }

    public function setCheckedHoverControl(string $control): self
    {
        $this->checkedHoverControl = $control;
        return $this;
    }

    public function setUncheckedHoverControl(string $control): self
    {
        $this->uncheckedHoverControl = $control;
        return $this;
    }

    public function setCheckedLockedControl(string $control): self
    {
        $this->checkedLockedControl = $control;
        return $this;
    }

    public function setUncheckedLockedControl(string $control): self
    {
        $this->uncheckedLockedControl = $control;
        return $this;
    }

    public function setCheckedLockedHoverControl(string $control): self
    {
        $this->checkedLockedHoverControl = $control;
        return $this;
    }

    public function setUncheckedLockedHoverControl(string $control): self
    {
        $this->uncheckedLockedHoverControl = $control;
        return $this;
    }

    public function setSoundName(string $sound): self
    {
        $this->soundName = $sound;
        return $this;
    }

    public function setSoundVolume(float $volume): self
    {
        $this->soundVolume = $volume;
        return $this;
    }

    public function setSoundPitch(float $pitch): self
    {
        $this->soundPitch = $pitch;
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
            "type" => "toggle",
            "toggle_name" => $this->toggleName,
            "toggle_default_state" => $this->toggleDefaultState,
            "toggle_group_default_tab" => $this->toggleGroupDefaultTab,
            "toggle_group_forced_index" => $this->toggleGroupForcedIndex,
            "reset_on_focus_lost" => $this->resetOnFocusLost,
            "toggle_on_button" => $this->toggleOnButton,
            "toggle_off_button" => $this->toggleOffButton,
            "enable_directional_toggling" => $this->enableDirectionalToggling,
            "radio_toggle_group" => $this->radioToggleGroup,
            "toggle_tab_index" => $this->toggleTabIndex,
            "sound_name" => $this->soundName,
            "sound_volume" => $this->soundVolume,
            "sound_pitch" => $this->soundPitch,
        ]];

        if ($this->checkedControl !== '') $element[$name]["checked_control"] = $this->checkedControl;
        if ($this->uncheckedControl !== '') $element[$name]["unchecked_control"] = $this->uncheckedControl;
        if ($this->checkedHoverControl !== '') $element[$name]["checked_hover_control"] = $this->checkedHoverControl;
        if ($this->uncheckedHoverControl !== '') $element[$name]["unchecked_hover_control"] = $this->uncheckedHoverControl;
        if ($this->checkedLockedControl !== '') $element[$name]["checked_locked_control"] = $this->checkedLockedControl;
        if ($this->uncheckedLockedControl !== '') $element[$name]["unchecked_locked_control"] = $this->uncheckedLockedControl;
        if ($this->checkedLockedHoverControl !== '') $element[$name]["checked_locked_hover_control"] = $this->checkedLockedHoverControl;
        if ($this->uncheckedLockedHoverControl !== '') $element[$name]["unchecked_locked_hover_control"] = $this->uncheckedLockedHoverControl;

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }

        return $element;
    }
}
