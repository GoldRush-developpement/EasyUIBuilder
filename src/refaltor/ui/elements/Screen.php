<?php

namespace refaltor\ui\elements;

class Screen extends Element implements \JsonSerializable
{
    private bool $renderOnlyWhenTopMost = true;
    private bool $renderGameBehind = true;
    private bool $absorbInput = true;
    private bool $isShowingMenu = true;
    private bool $isModal = true;
    private bool $shouldStealMouse = false;
    private bool $lowFreqRendering = true;
    private bool $screenNotFlushable = false;
    private bool $alwaysAcceptsInput = false;
    private bool $forceRenderBelow = false;
    private bool $sendTelemetry = false;
    private bool $closeOnPlayerHurt = false;
    private bool $cacheScreen = false;
    private string $screenDrawsLast = "";

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

    public function setRenderOnlyWhenTopMost(bool $render): self
    {
        $this->renderOnlyWhenTopMost = $render;
        return $this;
    }

    public function setRenderGameBehind(bool $render): self
    {
        $this->renderGameBehind = $render;
        return $this;
    }

    public function setAbsorbInput(bool $absorb): self
    {
        $this->absorbInput = $absorb;
        return $this;
    }

    public function setIsShowingMenu(bool $showing): self
    {
        $this->isShowingMenu = $showing;
        return $this;
    }

    public function setIsModal(bool $modal): self
    {
        $this->isModal = $modal;
        return $this;
    }

    public function setShouldStealMouse(bool $steal): self
    {
        $this->shouldStealMouse = $steal;
        return $this;
    }

    public function setLowFreqRendering(bool $low): self
    {
        $this->lowFreqRendering = $low;
        return $this;
    }

    public function setScreenNotFlushable(bool $notFlushable): self
    {
        $this->screenNotFlushable = $notFlushable;
        return $this;
    }

    public function setAlwaysAcceptsInput(bool $accepts): self
    {
        $this->alwaysAcceptsInput = $accepts;
        return $this;
    }

    public function setForceRenderBelow(bool $force): self
    {
        $this->forceRenderBelow = $force;
        return $this;
    }

    public function setSendTelemetry(bool $send): self
    {
        $this->sendTelemetry = $send;
        return $this;
    }

    public function setCloseOnPlayerHurt(bool $close): self
    {
        $this->closeOnPlayerHurt = $close;
        return $this;
    }

    public function setCacheScreen(bool $cache): self
    {
        $this->cacheScreen = $cache;
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
            "type" => "screen",
            "render_only_when_topmost" => $this->renderOnlyWhenTopMost,
            "render_game_behind" => $this->renderGameBehind,
            "absorbs_input" => $this->absorbInput,
            "is_showing_menu" => $this->isShowingMenu,
            "is_modal" => $this->isModal,
            "should_steal_mouse" => $this->shouldStealMouse,
            "low_frequency_rendering" => $this->lowFreqRendering,
            "screen_not_flushable" => $this->screenNotFlushable,
            "always_accepts_input" => $this->alwaysAcceptsInput,
            "force_render_below" => $this->forceRenderBelow,
            "send_telemetry" => $this->sendTelemetry,
            "close_on_player_hurt" => $this->closeOnPlayerHurt,
            "cache_screen" => $this->cacheScreen,
        ]];

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }

        if (!empty($dataParent['modifications'])) {
            $element[$name]["modifications"] = $dataParent['modifications'];
        }

        return $element;
    }
}
