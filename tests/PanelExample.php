<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;

/**
 * PanelExample - Demonstrates Panel features.
 *
 * Shows: nested panels, background images, alpha, clipping, child elements.
 */
class PanelExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        // Main container panel (fullscreen)
        $mainPanel = Panel::create("main_panel")
            ->setSizePercentage(100, 100);

        // Background image inside the panel
        $bg = Image::create("bg_image", "textures/ui/background")
            ->setSizePercentage(100, 100)
            ->setKeepRatio(false)
            ->setNinesliceSize(4);
        $mainPanel->addChild($bg);

        // Inner panel with fixed size and alpha
        $innerPanel = Panel::create("inner_panel")
            ->setSize(200, 150)
            ->setAlpha(0.9)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);

        // Label inside inner panel
        $label = Label::create("panel_title", "Inner Panel")
            ->setFontSize(Label::FONT_LARGE)
            ->setShadow()
            ->setColor(BasicColor::white())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 5);
        $innerPanel->addChild($label);

        // Nested child panel with clipping enabled
        $clippedPanel = Panel::create("clipped_panel")
            ->setSize(180, 80)
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setOffset(0, -10);

        $clippedLabel = Label::create("clipped_text", "This text is inside a clipped panel")
            ->setFontSize(Label::FONT_SMALL)
            ->setColor(BasicColor::cyan());
        $clippedPanel->addChild($clippedLabel);

        $innerPanel->addChild($clippedPanel);
        $mainPanel->addChild($innerPanel);

        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "panel_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "PANEL_EXAMPLE";
    }
}
