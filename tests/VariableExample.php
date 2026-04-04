<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\components\Variable;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\StackPanel;
use refaltor\ui\helpers\OrientationHelper;

/**
 * VariableExample - Demonstrates the Variable (conditional) system.
 *
 * Shows: conditional variables, platform-specific sizing,
 *        gamepad vs touch vs keyboard layouts, multiple variables.
 */
class VariableExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $mainPanel = Panel::create("variable_container")
            ->setSizePercentage(100, 100);

        // Background
        $bg = Image::create("variable_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $mainPanel->addChild($bg);

        // Title
        $title = Label::create("variable_title", "Variable Examples")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $mainPanel->addChild($title);

        $stack = StackPanel::create("variable_stack")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setSize(300, 250)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);

        // Panel with platform-dependent size using variables
        $platformPanel = Panel::create("platform_panel")
            ->setCustomSize(['$panel_width', '$panel_height'])
            ->addVariable(
                Variable::when('$is_holographic', [
                    '$panel_width' => 400,
                    '$panel_height' => 300,
                ])
            )
            ->addVariable(
                Variable::when('$pocket_screen', [
                    '$panel_width' => 200,
                    '$panel_height' => 150,
                ])
            )
            ->addVariable(
                Variable::when('(not $is_holographic and not $pocket_screen)', [
                    '$panel_width' => 300,
                    '$panel_height' => 200,
                ])
            );

        $platformLabel = Label::create("platform_label", "Size adapts to platform!")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::cyan())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $platformPanel->addChild($platformLabel);
        $stack->addChild($platformPanel);

        // Input-mode dependent text using variables
        $inputPanel = Panel::create("input_mode_panel")
            ->setSize(280, 40)
            ->addVariable(
                Variable::when('$is_using_gamepad', [
                    '$action_text' => "Press A to continue",
                    '$text_color' => BasicColor::green(),
                ])
            )
            ->addVariable(
                Variable::when('$touch', [
                    '$action_text' => "Tap to continue",
                    '$text_color' => BasicColor::cyan(),
                ])
            )
            ->addVariable(
                Variable::when('(not $is_using_gamepad and not $touch)', [
                    '$action_text' => "Click to continue",
                    '$text_color' => BasicColor::white(),
                ])
            );

        $inputLabel = Label::create("input_label", '$action_text')
            ->setFontSize(Label::FONT_LARGE)
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $inputPanel->addChild($inputLabel);
        $stack->addChild($inputPanel);

        // Panel visible only on certain screen size
        $widePanel = Panel::create("wide_screen_only")
            ->setSize(280, 30)
            ->addVariable(
                Variable::when('$desktop_screen', [
                    '$show_extra_info' => true,
                ])
            )
            ->addVariable(
                Variable::when('(not $desktop_screen)', [
                    '$show_extra_info' => false,
                ])
            );

        $wideLabel = Label::create("wide_label", "Desktop-only extra info panel")
            ->setFontSize(Label::FONT_SMALL)
            ->setColor(BasicColor::rgb(0.8, 0.8, 0.3))
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $widePanel->addChild($wideLabel);
        $stack->addChild($widePanel);

        // Multiple variables on one element (stacked conditions)
        $multiVarPanel = Panel::create("multi_var_panel")
            ->setCustomSize(['$mv_width', '$mv_height'])
            ->addVariables([
                Variable::when('$trial_screen', [
                    '$mv_width' => 150,
                    '$mv_height' => 80,
                    '$mv_text' => "Trial Mode",
                ]),
                Variable::when('(not $trial_screen)', [
                    '$mv_width' => 250,
                    '$mv_height' => 60,
                    '$mv_text' => "Full Version",
                ]),
            ]);

        $multiVarLabel = Label::create("multi_var_label", '$mv_text')
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::magenta())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $multiVarPanel->addChild($multiVarLabel);
        $stack->addChild($multiVarPanel);

        $mainPanel->addChild($stack);
        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "variable_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "VARIABLE_EXAMPLE";
    }
}
