<?php

namespace refaltor\ui\elements;

class CustomRender extends Element implements \JsonSerializable
{
    private string $renderer = "";
    private array $propertyBag = [];
    private string $primaryColor = "";
    private bool $enableProfanityFilter = false;
    private bool $locked = false;
    private array $color = [1.0, 1.0, 1.0, 1.0];

    const RENDERER_PAPER_DOLL = "paper_doll_renderer";
    const RENDERER_LIVE_HORSE = "live_horse_renderer";
    const RENDERER_LIVE_PLAYER = "live_player_renderer";
    const RENDERER_INVENTORY_ITEM = "inventory_item_renderer";
    const RENDERER_HOTBAR_ITEM = "hotbar_item_renderer";
    const RENDERER_HUD_PLAYER = "hud_player_renderer";
    const RENDERER_ENCHANTING_BOOK = "enchanting_book_renderer";
    const RENDERER_3D_STRUCTURE = "3d_structure_renderer";
    const RENDERER_PROGRESS_BAR = "progress_bar_renderer";
    const RENDERER_ACTOR_PORTRAIT = "actor_portrait_renderer";
    const RENDERER_BANNER = "banner_renderer";
    const RENDERER_TRIAL = "trial_renderer";
    const RENDERER_PANORAMA = "panorama_renderer";
    const RENDERER_GRADIENT = "gradient_renderer";
    const RENDERER_NAME_TAG = "name_tag_renderer";
    const RENDERER_FLYING_ITEM = "flying_item_renderer";
    const RENDERER_HOVER_TEXT = "hover_text_renderer";
    const RENDERER_CREDITS = "credits_renderer";
    const RENDERER_VIGNETTE = "vignette_renderer";
    const RENDERER_SPLASH_TEXT = "splash_text_renderer";

    public function __construct(string $name, string $renderer, ?string $extend = null)
    {
        $this->name = $name;
        $this->renderer = $renderer;
        $this->extend = $extend;
        parent::__construct($name, $extend);
    }

    public static function create(string $name, string $renderer): self
    {
        return new self($name, $renderer);
    }

    public function setRenderer(string $renderer): self
    {
        $this->renderer = $renderer;
        return $this;
    }

    public function setPropertyBag(array $propertyBag): self
    {
        $this->propertyBag = $propertyBag;
        return $this;
    }

    public function addProperty(string $key, $value): self
    {
        $this->propertyBag[$key] = $value;
        return $this;
    }

    public function setPrimaryColor(string $color): self
    {
        $this->primaryColor = $color;
        return $this;
    }

    public function setEnableProfanityFilter(bool $enable): self
    {
        $this->enableProfanityFilter = $enable;
        return $this;
    }

    public function setLocked(bool $locked): self
    {
        $this->locked = $locked;
        return $this;
    }

    public function setColor(array $color): self
    {
        $this->color = $color;
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
            "type" => "custom",
            "renderer" => $this->renderer,
        ]];

        if (!empty($this->propertyBag)) $element[$name]["property_bag"] = $this->propertyBag;
        if ($this->primaryColor !== '') $element[$name]["primary_color"] = $this->primaryColor;
        if ($this->enableProfanityFilter) $element[$name]["enable_profanity_filter"] = true;
        if ($this->locked) $element[$name]["locked"] = true;
        $element[$name]["color"] = $this->color;

        foreach ($propertiesExtra as $propertyName => $property) {
            $element[$name][$propertyName] = $property;
        }

        foreach ($controls as $control) {
            $element[$name]["controls"][] = $control;
        }

        if (!empty($dataParent['bindings'])) {
            $element[$name]["bindings"] = $dataParent['bindings'];
        }
        if (!empty($dataParent['modifications'])) {
            $element[$name]["modifications"] = $dataParent['modifications'];
        }

        return $element;
    }
}
