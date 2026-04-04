<?php

namespace refaltor\ui\elements;

class InputPanel extends Element implements \JsonSerializable
{
    private bool $modal = false;
    private bool $inlineModal = false;
    private bool $alwaysListenToInput = false;
    private bool $focusEnabled = true;
    private string $focusWrapEnabled = "";
    private string $focusMagnetEnabled = "";
    private string $focusMagnetDistance = "";
    private string $focusIdentifier = "";
    private string $focusChangeUp = "";
    private string $focusChangeDown = "";
    private string $focusChangeLeft = "";
    private string $focusChangeRight = "";
    private bool $focusNavigationModeLeft = false;
    private bool $focusNavigationModeRight = false;
    private bool $focusNavigationModeUp = false;
    private bool $focusNavigationModeDown = false;
    private string $focusContainerCustom = "";
    private bool $useLastFocus = false;
    private bool $gestureTrackingButton = false;
    private bool $alwaysHandlePointer = false;
    private array $buttonMappings = [];
    private bool $defaultFocusPrecedence = false;

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

    public function setModal(bool $modal): self
    {
        $this->modal = $modal;
        return $this;
    }

    public function setInlineModal(bool $inline): self
    {
        $this->inlineModal = $inline;
        return $this;
    }

    public function setAlwaysListenToInput(bool $listen): self
    {
        $this->alwaysListenToInput = $listen;
        return $this;
    }

    public function setFocusEnabled(bool $enabled): self
    {
        $this->focusEnabled = $enabled;
        return $this;
    }

    public function setFocusIdentifier(string $identifier): self
    {
        $this->focusIdentifier = $identifier;
        return $this;
    }

    public function setFocusChangeUp(string $control): self
    {
        $this->focusChangeUp = $control;
        return $this;
    }

    public function setFocusChangeDown(string $control): self
    {
        $this->focusChangeDown = $control;
        return $this;
    }

    public function setFocusChangeLeft(string $control): self
    {
        $this->focusChangeLeft = $control;
        return $this;
    }

    public function setFocusChangeRight(string $control): self
    {
        $this->focusChangeRight = $control;
        return $this;
    }

    public function setUseLastFocus(bool $use): self
    {
        $this->useLastFocus = $use;
        return $this;
    }

    public function setGestureTrackingButton(bool $gesture): self
    {
        $this->gestureTrackingButton = $gesture;
        return $this;
    }

    public function setAlwaysHandlePointer(bool $handle): self
    {
        $this->alwaysHandlePointer = $handle;
        return $this;
    }

    public function setDefaultFocusPrecedence(bool $precedence): self
    {
        $this->defaultFocusPrecedence = $precedence;
        return $this;
    }

    public function addButtonMapping(string $fromButton, string $toButton, string $mappingType = "pressed", string $inputModeCondition = "not_gaze"): self
    {
        $this->buttonMappings[] = [
            "from_button_id" => $fromButton,
            "to_button_id" => $toButton,
            "mapping_type" => $mappingType,
            "input_mode_condition" => $inputModeCondition,
        ];
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
            "type" => "input_panel",
            "modal" => $this->modal,
            "inline_modal" => $this->inlineModal,
            "always_listen_to_input" => $this->alwaysListenToInput,
            "focus_enabled" => $this->focusEnabled,
            "gesture_tracking_button" => $this->gestureTrackingButton,
            "always_handle_pointer" => $this->alwaysHandlePointer,
            "default_focus_precedence" => $this->defaultFocusPrecedence,
        ]];

        if ($this->focusIdentifier !== '') $element[$name]["focus_identifier"] = $this->focusIdentifier;
        if ($this->focusChangeUp !== '') $element[$name]["focus_change_up"] = $this->focusChangeUp;
        if ($this->focusChangeDown !== '') $element[$name]["focus_change_down"] = $this->focusChangeDown;
        if ($this->focusChangeLeft !== '') $element[$name]["focus_change_left"] = $this->focusChangeLeft;
        if ($this->focusChangeRight !== '') $element[$name]["focus_change_right"] = $this->focusChangeRight;
        if (!empty($this->buttonMappings)) $element[$name]["button_mappings"] = $this->buttonMappings;

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }

        return $element;
    }
}
