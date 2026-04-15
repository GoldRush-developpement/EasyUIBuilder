<?php

namespace refaltor\ui\builders;

use refaltor\ui\components\Animation;
use refaltor\ui\components\Modification;
use refaltor\ui\elements\Element;

class Root implements \JsonSerializable
{
    private array $root = [];
    public array $elements = [];
    public string $namespace;
    private string $title = "";
    private array $animations = [];
    private array $vanillaModifications = [];

    public function __construct(string $namespace) {
        $this->setNamespace($namespace);
    }

    public function setTitleCondition(string $title): self {
        $this->title = $title;
        return $this;
    }

    public static function create(string $namespace = ""): self {
        return new self($namespace);
    }

    public function setNamespace(string $namespace): self {
        $this->root["namespace"] = $namespace;
        $this->namespace = $namespace;
        return $this;
    }

    public function addElement(Element $element): self {
        $this->elements[] = $element;
        return $this;
    }

    public function addElements(array $elements): self {
        foreach ($elements as $element) {
            $this->elements[] = $element;
        }
        return $this;
    }

    public function addAnimation(Animation $animation): self {
        $this->animations[] = $animation;
        return $this;
    }

    public function addAnimations(array $animations): self {
        foreach ($animations as $animation) {
            $this->animations[] = $animation;
        }
        return $this;
    }

    /**
     * Add modifications targeting a vanilla UI element using the path syntax.
     * Example: "hud_title_text/title_frame/title" targets a nested vanilla element.
     *
     * @param string $elementPath The vanilla element path (e.g. "hud_screen/hud_title_text")
     * @param Modification[] $modifications Array of Modification objects
     */
    public function modifyVanillaElement(string $elementPath, array $modifications): self
    {
        if (!isset($this->vanillaModifications[$elementPath])) {
            $this->vanillaModifications[$elementPath] = [];
        }
        foreach ($modifications as $modification) {
            $this->vanillaModifications[$elementPath][] = $modification;
        }
        return $this;
    }

    public function jsonSerialize(): mixed
    {
        $root = ['namespace' => $this->namespace];

        foreach ($this->elements as $element) {
            if (!is_array($element)) {
                $root = array_merge($root, $element->jsonSerialize());
            }
        }

        foreach ($this->elements as $name => $element) {
            if ($name === "template_button_easy_ui_builder@common_buttons.light_text_button") {
                $root['template_button_easy_ui_builder@common_buttons.light_text_button'] = $element;
            }
            if ($name === "template_button_easy_ui_builder_stack_panel") {
                $root['template_button_easy_ui_builder_stack_panel'] = $element;
            }
        }

        foreach ($this->animations as $animation) {
            $serialized = $animation->jsonSerialize();
            foreach ($serialized as $animName => $animData) {
                $root[$animName] = $animData;
            }
        }

        foreach ($this->vanillaModifications as $elementPath => $modifications) {
            $root[$elementPath] = [
                'modifications' => array_map(fn($m) => $m->jsonSerialize(), $modifications),
            ];
        }

        return $root;
    }

    public function generateAndSaveJson(string $filename): void {
        $json = json_encode($this, JSON_PRETTY_PRINT);
        $filePath =  $filename;
        file_put_contents($filePath, $json);
    }
}