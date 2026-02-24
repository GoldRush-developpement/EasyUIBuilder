<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\StackPanel;
use refaltor\ui\helpers\OrientationHelper;

/**
 * StackPanelExample - Demonstrates StackPanel layouts.
 *
 * Shows: vertical stacking, horizontal stacking, nested stack panels.
 */
class StackPanelExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        // Vertical stack panel (menu-like layout)
        $verticalStack = StackPanel::create("vertical_menu")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setSize(200, 200)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);

        // Add labels as menu items
        $item1 = Label::create("menu_item_1", "Play Game")
            ->setFontSize(Label::FONT_LARGE)
            ->setShadow()
            ->setColor(BasicColor::white())
            ->setSize(200, 30);
        $verticalStack->addChild($item1);

        $item2 = Label::create("menu_item_2", "Settings")
            ->setFontSize(Label::FONT_LARGE)
            ->setShadow()
            ->setColor(BasicColor::white())
            ->setSize(200, 30);
        $verticalStack->addChild($item2);

        $item3 = Label::create("menu_item_3", "Credits")
            ->setFontSize(Label::FONT_LARGE)
            ->setShadow()
            ->setColor(BasicColor::white())
            ->setSize(200, 30);
        $verticalStack->addChild($item3);

        $root->addElement($verticalStack);

        // Horizontal stack panel (toolbar-like layout)
        $horizontalStack = StackPanel::create("toolbar")
            ->setOrientation(OrientationHelper::HORIZONTAL)
            ->setCustomSize(["100%", 40])
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_MIDDLE);

        $btn1 = Label::create("tool_1", "Home")
            ->setColor(BasicColor::yellow())
            ->setSize(80, 40);
        $horizontalStack->addChild($btn1);

        $btn2 = Label::create("tool_2", "Inventory")
            ->setColor(BasicColor::cyan())
            ->setSize(80, 40);
        $horizontalStack->addChild($btn2);

        $btn3 = Label::create("tool_3", "Map")
            ->setColor(BasicColor::green())
            ->setSize(80, 40);
        $horizontalStack->addChild($btn3);

        $root->addElement($horizontalStack);

        return $root;
    }

    public function getNamespace(): string
    {
        return "stackpanel_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "STACKPANEL_EXAMPLE";
    }
}
