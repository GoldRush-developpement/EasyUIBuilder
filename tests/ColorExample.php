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
 * ColorExample - Demonstrates all BasicColor functions.
 *
 * Shows: predefined colors, rgb(), randomColor(), randomPastelColor(),
 *        randomShadeOfGray(), complementaryColor().
 */
class ColorExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $stack = StackPanel::create("color_stack")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setSize(250, 300)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);

        // Predefined colors
        $colors = [
            "White"   => BasicColor::white(),
            "Black"   => BasicColor::black(),
            "Red"     => BasicColor::red(),
            "Green"   => BasicColor::green(),
            "Blue"    => BasicColor::blue(),
            "Yellow"  => BasicColor::yellow(),
            "Cyan"    => BasicColor::cyan(),
            "Magenta" => BasicColor::magenta(),
        ];

        foreach ($colors as $name => $color) {
            $label = Label::create("color_" . strtolower($name), $name)
                ->setColor($color)
                ->setShadow()
                ->setFontSize(Label::FONT_NORMAL)
                ->setSize(250, 20);
            $stack->addChild($label);
        }

        // Custom RGB color
        $rgbLabel = Label::create("rgb_custom", "Custom RGB (0.5, 0.3, 0.9)")
            ->setColor(BasicColor::rgb(0.5, 0.3, 0.9))
            ->setShadow()
            ->setSize(250, 20);
        $stack->addChild($rgbLabel);

        // Random color (changes each generation)
        $randomLabel = Label::create("random_color", "Random Color")
            ->setColor(BasicColor::randomColor())
            ->setShadow()
            ->setSize(250, 20);
        $stack->addChild($randomLabel);

        // Random pastel color
        $pastelLabel = Label::create("pastel_color", "Random Pastel")
            ->setColor(BasicColor::randomPastelColor())
            ->setShadow()
            ->setSize(250, 20);
        $stack->addChild($pastelLabel);

        // Random gray shade
        $grayLabel = Label::create("gray_shade", "Random Gray Shade")
            ->setColor(BasicColor::randomShadeOfGray())
            ->setShadow()
            ->setSize(250, 20);
        $stack->addChild($grayLabel);

        // Complementary color of red
        $compLabel = Label::create("complementary", "Complementary of Red")
            ->setColor(BasicColor::complementaryColor(BasicColor::red()))
            ->setShadow()
            ->setSize(250, 20);
        $stack->addChild($compLabel);

        $root->addElement($stack);

        return $root;
    }

    public function getNamespace(): string
    {
        return "color_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "COLOR_EXAMPLE";
    }
}
