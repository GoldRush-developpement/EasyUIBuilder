<?php

namespace refaltor\ui\builders;

use refaltor\ui\elements\Element;

class Root implements \JsonSerializable
{
    private array $root = [];
    public array $elements = [];
    public string $namespace;

    public function __construct(string $namespace) {
        $this->setNamespace($namespace);
    }

    public static function create(string $namespace): self {
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
            $this->elements[] = $elements;
        }
        return $this;
    }

    public function jsonSerialize()
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

        return $root;
    }

    public function generateAndSaveJson(string $filename): void {
        $json = json_encode($this, JSON_PRETTY_PRINT);
        $filePath =  $filename;
        var_dump($filePath);
        file_put_contents($filePath, $json);

        echo "Le fichier JSON a été enregistré sous : " . $filePath;
    }
}