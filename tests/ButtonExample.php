<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\elements\Button;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Panel;

/**
 * ButtonExample - Demonstrates Button configurations.
 *
 * Shows: custom textures, visibility conditions, button text, sizing.
 */
class ButtonExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        // Container panel
        $panel = Panel::create("button_container")
            ->setSizePercentage(100, 100);

        // Enable button factory (required for buttons)
        $panel->enableFactoryButton($root);

        // Simple button with default textures
        $simpleBtn = Button::create("simple_button", $root)
            ->setButtonText("Click Me")
            ->setVisibleIfTitle("Click Me")
            ->setSize(200, 30)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->setOffset(0, -30);
        $panel->addChild($simpleBtn);

        // Button with custom textures
        $customBtn = Button::create("custom_button", $root)
            ->setButtonText("Custom Style")
            ->setVisibleIfTitle("Custom Style")
            ->setDefaultButtonTexture("textures/ui/button_default")
            ->setHoverButtonTexture("textures/ui/button_hover")
            ->setPressedButtonTexture("textures/ui/button_pressed")
            ->setLockedButtonTexture("textures/ui/button_locked")
            ->setSize(200, 30)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->setOffset(0, 10);
        $panel->addChild($customBtn);

        // Small button anchored to bottom
        $smallBtn = Button::create("small_button", $root)
            ->setButtonText("Exit")
            ->setVisibleIfTitle("Exit")
            ->setSize(100, 20)
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setOffset(0, -10);
        $panel->addChild($smallBtn);

        $root->addElement($panel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "button_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "BUTTON_EXAMPLE";
    }
}
