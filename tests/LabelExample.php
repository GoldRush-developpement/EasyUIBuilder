<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Label;

/**
 * LabelExample - Demonstrates various Label configurations.
 *
 * Shows: font sizes, font types, colors, shadows, scaling, anchoring.
 */
class LabelExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        // Basic label with default settings
        $basicLabel = Label::create("basic_label", "Hello World!")
            ->setFontSize(Label::FONT_NORMAL);
        $root->addElement($basicLabel);

        // Extra large label with shadow
        $titleLabel = Label::create("title_label", "Game Title")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $root->addElement($titleLabel);

        // Small label with custom color
        $subtitleLabel = Label::create("subtitle_label", "A subtitle in cyan")
            ->setFontSize(Label::FONT_SMALL)
            ->setColor(BasicColor::cyan())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 30);
        $root->addElement($subtitleLabel);

        // Label with MinecraftTen font type
        $minecraftFont = Label::create("minecraft_font_label", "MinecraftTen Font")
            ->setFontType(Label::TYPE_MINECRAFT_TEN)
            ->setFontSize(Label::FONT_LARGE)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $root->addElement($minecraftFont);

        // Label with scale factor
        $scaledLabel = Label::create("scaled_label", "Scaled x2")
            ->setFontScaleFactor(2.0)
            ->setColor(BasicColor::red())
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setOffset(0, -20);
        $root->addElement($scaledLabel);

        // Label with RGB custom color
        $customColor = Label::create("custom_color_label", "Custom RGB Color")
            ->setColor(BasicColor::rgb(0.5, 0.8, 0.2))
            ->setFontSize(Label::FONT_LARGE)
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_LEFT)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_LEFT)
            ->setOffset(10, -10);
        $root->addElement($customColor);

        return $root;
    }

    public function getNamespace(): string
    {
        return "label_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "LABEL_EXAMPLE";
    }
}
