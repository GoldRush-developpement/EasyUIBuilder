<?php

namespace refaltor\ui\elements;

class Panel extends Element implements \JsonSerializable
{
    private bool $visible = true;
    private bool $enabled = true;
    private int $layer = 0;
    private float $alpha = 1.0;
    private bool $propagateAlpha = false;
    private bool $clipsChildren = false;
    private bool $allowClipping = true;
    private array $clipOffset = [0, 0];
    private string $clipStateChangeEvent = '';
    private bool $enableScissorTest = false;
    private array $propertyBag = [];
    private bool $selected = false;
    private bool $useChildAnchors = false;
    private array $anims = [];
    private bool $disableAnimFastForward = false;
    private string $animationResetName = '';
    private bool $ignored = false;
    private array $variables = [];
    private array $modifications = [];
    private array $gridPosition = [0, 0];
    private int $collectionIndex = 0;

    public function __construct(
        string $name,
        ?string $extend = null
    )
    {
        $this->name = $name;
        $this->extend = $extend;

        parent::__construct($name, $extend);
    }

    public static function create(string $name): self {
        return new self($name);
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
            "type" => "panel",
            "visible" => $this->visible,
            "enabled" => $this->enabled,
            "layer" => $this->layer,
            "alpha" => $this->alpha,
            "propagate_alpha" => $this->propagateAlpha,
            "clips_children" => $this->clipsChildren,
            "allow_clipping" => $this->allowClipping,
            "clip_offset" => $this->clipOffset,
            "clip_state_change_event" => $this->clipStateChangeEvent,
            "enable_scissor_test" => $this->enableScissorTest,
            "property_bag" => $this->propertyBag,
            "selected" => $this->selected,
            "use_child_anchors" => $this->useChildAnchors,
            "anims" => $this->anims,
            "disable_anim_fast_forward" => $this->disableAnimFastForward,
            "animation_reset_name" => $this->animationResetName,
            //"ignored" => $this->ignored,
            "variables" => $this->variables,
            //"modifications" => $this->modifications,
            //"grid_position" => $this->gridPosition,
            //"collection_index" => $this->collectionIndex,
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
