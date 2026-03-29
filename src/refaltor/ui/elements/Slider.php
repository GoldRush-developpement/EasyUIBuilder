<?php

namespace refaltor\ui\elements;

class Slider extends Element implements \JsonSerializable
{
    private string $sliderTrackButton = "button.menu_select";
    private string $sliderSmallDecreaseButton = "";
    private string $sliderSmallIncreaseButton = "";
    private float $sliderSteps = 1.0;
    private string $sliderDirection = "horizontal";
    private float $sliderTimeout = 0.0;
    private string $sliderCollectionName = "";
    private string $sliderName = "";
    private bool $sliderSelectOnHover = false;
    private float $defaultControlValue = 0.0;
    private string $backgroundControl = "";
    private string $backgroundHoverControl = "";
    private string $progressControl = "";
    private string $progressHoverControl = "";
    private string $sliderBoxControl = "";
    private string $sliderBoxHoverControl = "";
    private string $sliderBoxLockedControl = "";
    private string $sliderBoxIndeterminateControl = "";

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

    public function setSliderTrackButton(string $button): self
    {
        $this->sliderTrackButton = $button;
        return $this;
    }

    public function setSliderSmallDecreaseButton(string $button): self
    {
        $this->sliderSmallDecreaseButton = $button;
        return $this;
    }

    public function setSliderSmallIncreaseButton(string $button): self
    {
        $this->sliderSmallIncreaseButton = $button;
        return $this;
    }

    public function setSliderSteps(float $steps): self
    {
        $this->sliderSteps = $steps;
        return $this;
    }

    public function setSliderDirection(string $direction): self
    {
        $this->sliderDirection = $direction;
        return $this;
    }

    public function setSliderTimeout(float $timeout): self
    {
        $this->sliderTimeout = $timeout;
        return $this;
    }

    public function setSliderCollectionName(string $name): self
    {
        $this->sliderCollectionName = $name;
        return $this;
    }

    public function setSliderName(string $name): self
    {
        $this->sliderName = $name;
        return $this;
    }

    public function setSliderSelectOnHover(bool $select): self
    {
        $this->sliderSelectOnHover = $select;
        return $this;
    }

    public function setDefaultControlValue(float $value): self
    {
        $this->defaultControlValue = $value;
        return $this;
    }

    public function setBackgroundControl(string $control): self
    {
        $this->backgroundControl = $control;
        return $this;
    }

    public function setBackgroundHoverControl(string $control): self
    {
        $this->backgroundHoverControl = $control;
        return $this;
    }

    public function setProgressControl(string $control): self
    {
        $this->progressControl = $control;
        return $this;
    }

    public function setProgressHoverControl(string $control): self
    {
        $this->progressHoverControl = $control;
        return $this;
    }

    public function setSliderBoxControl(string $control): self
    {
        $this->sliderBoxControl = $control;
        return $this;
    }

    public function setSliderBoxHoverControl(string $control): self
    {
        $this->sliderBoxHoverControl = $control;
        return $this;
    }

    public function setSliderBoxLockedControl(string $control): self
    {
        $this->sliderBoxLockedControl = $control;
        return $this;
    }

    public function setSliderBoxIndeterminateControl(string $control): self
    {
        $this->sliderBoxIndeterminateControl = $control;
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
            "type" => "slider",
            "slider_track_button" => $this->sliderTrackButton,
            "slider_steps" => $this->sliderSteps,
            "slider_direction" => $this->sliderDirection,
            "slider_timeout" => $this->sliderTimeout,
            "slider_select_on_hover" => $this->sliderSelectOnHover,
            "default_control" => $this->defaultControlValue,
        ]];

        if ($this->sliderSmallDecreaseButton !== '') $element[$name]["slider_small_decrease_button"] = $this->sliderSmallDecreaseButton;
        if ($this->sliderSmallIncreaseButton !== '') $element[$name]["slider_small_increase_button"] = $this->sliderSmallIncreaseButton;
        if ($this->sliderCollectionName !== '') $element[$name]["slider_collection_name"] = $this->sliderCollectionName;
        if ($this->sliderName !== '') $element[$name]["slider_name"] = $this->sliderName;
        if ($this->backgroundControl !== '') $element[$name]["background_control"] = $this->backgroundControl;
        if ($this->backgroundHoverControl !== '') $element[$name]["background_hover_control"] = $this->backgroundHoverControl;
        if ($this->progressControl !== '') $element[$name]["progress_control"] = $this->progressControl;
        if ($this->progressHoverControl !== '') $element[$name]["progress_hover_control"] = $this->progressHoverControl;
        if ($this->sliderBoxControl !== '') $element[$name]["slider_box_control"] = $this->sliderBoxControl;
        if ($this->sliderBoxHoverControl !== '') $element[$name]["slider_box_hover_control"] = $this->sliderBoxHoverControl;
        if ($this->sliderBoxLockedControl !== '') $element[$name]["slider_box_locked_control"] = $this->sliderBoxLockedControl;
        if ($this->sliderBoxIndeterminateControl !== '') $element[$name]["slider_box_indeterminate_control"] = $this->sliderBoxIndeterminateControl;

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }

        return $element;
    }
}
