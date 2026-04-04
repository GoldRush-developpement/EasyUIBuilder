<?php

namespace refaltor\ui\elements;

class ScrollView extends Element implements \JsonSerializable
{
    private string $scrollViewPort = "";
    private string $scrollContent = "";
    private string $scrollBarTrack = "";
    private string $scrollBarBox = "";
    private string $scrollBarBoxTrack = "";
    private float $scrollSpeed = 1.0;
    private float $scrollBarBoxMiddleSize = 0.0;
    private bool $alwaysListenToInput = true;
    private bool $jumpToBottomOnUpdate = false;
    private bool $touchMode = false;
    private bool $scrollbarTrackButton = false;
    private string $scrollSize = "";
    private string $orientation = "vertical";

    const ORIENTATION_VERTICAL = "vertical";
    const ORIENTATION_HORIZONTAL = "horizontal";

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

    public function setScrollViewPort(string $viewPort): self
    {
        $this->scrollViewPort = $viewPort;
        return $this;
    }

    public function setScrollContent(string $content): self
    {
        $this->scrollContent = $content;
        return $this;
    }

    public function setScrollBarTrack(string $track): self
    {
        $this->scrollBarTrack = $track;
        return $this;
    }

    public function setScrollBarBox(string $box): self
    {
        $this->scrollBarBox = $box;
        return $this;
    }

    public function setScrollBarBoxTrack(string $boxTrack): self
    {
        $this->scrollBarBoxTrack = $boxTrack;
        return $this;
    }

    public function setScrollSpeed(float $speed): self
    {
        $this->scrollSpeed = $speed;
        return $this;
    }

    public function setScrollBarBoxMiddleSize(float $size): self
    {
        $this->scrollBarBoxMiddleSize = $size;
        return $this;
    }

    public function setAlwaysListenToInput(bool $listen): self
    {
        $this->alwaysListenToInput = $listen;
        return $this;
    }

    public function setJumpToBottomOnUpdate(bool $jump): self
    {
        $this->jumpToBottomOnUpdate = $jump;
        return $this;
    }

    public function setTouchMode(bool $touch): self
    {
        $this->touchMode = $touch;
        return $this;
    }

    public function setScrollbarTrackButton(bool $button): self
    {
        $this->scrollbarTrackButton = $button;
        return $this;
    }

    public function setScrollSize(string $size): self
    {
        $this->scrollSize = $size;
        return $this;
    }

    public function setOrientation(string $orientation): self
    {
        $this->orientation = $orientation;
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
            "type" => "scroll_view",
            "scroll_speed" => $this->scrollSpeed,
            "always_listen_to_input" => $this->alwaysListenToInput,
            "jump_to_bottom_on_update" => $this->jumpToBottomOnUpdate,
            "touch_mode" => $this->touchMode,
            "scrollbar_track_button" => $this->scrollbarTrackButton,
            "orientation" => $this->orientation,
        ]];

        if ($this->scrollViewPort !== '') $element[$name]["scrollbar_touch_button"] = $this->scrollViewPort;
        if ($this->scrollContent !== '') $element[$name]["scroll_content"] = $this->scrollContent;
        if ($this->scrollBarTrack !== '') $element[$name]["scroll_bar_track"] = $this->scrollBarTrack;
        if ($this->scrollBarBox !== '') $element[$name]["scroll_bar_box"] = $this->scrollBarBox;
        if ($this->scrollBarBoxTrack !== '') $element[$name]["scroll_bar_box_track"] = $this->scrollBarBoxTrack;
        if ($this->scrollBarBoxMiddleSize > 0) $element[$name]["scroll_bar_box_middle_size"] = $this->scrollBarBoxMiddleSize;
        if ($this->scrollSize !== '') $element[$name]["scroll_size"] = $this->scrollSize;

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }

        return $element;
    }
}
