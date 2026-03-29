<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\StackPanel;
use refaltor\ui\elements\Toggle;
use refaltor\ui\helpers\OrientationHelper;

/**
 * ToggleExample - Demonstrates Toggle element configurations.
 *
 * Shows: basic toggle, radio group, custom checked/unchecked controls,
 *        sound settings, tab navigation.
 */
class ToggleExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $mainPanel = Panel::create("toggle_container")
            ->setSizePercentage(100, 100);

        // Background
        $bg = Image::create("toggle_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $mainPanel->addChild($bg);

        // Title
        $title = Label::create("toggle_title", "Toggle Examples")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $mainPanel->addChild($title);

        // Vertical stack for toggles
        $stack = StackPanel::create("toggle_stack")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setSize(250, 200)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);

        // Basic on/off toggle (like a settings switch)
        $basicToggle = Toggle::create("music_toggle")
            ->setToggleName("toggle_music")
            ->setToggleDefaultState(true)
            ->setSoundName("random.click")
            ->setSoundVolume(0.8)
            ->setSize(150, 30)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $stack->addChild($basicToggle);

        // Toggle with custom checked/unchecked visuals
        $visualToggle = Toggle::create("particles_toggle")
            ->setToggleName("toggle_particles")
            ->setToggleDefaultState(false)
            ->setCheckedControl("checked_image")
            ->setUncheckedControl("unchecked_image")
            ->setCheckedHoverControl("checked_hover_image")
            ->setUncheckedHoverControl("unchecked_hover_image")
            ->setSize(150, 30)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $stack->addChild($visualToggle);

        // Radio toggle group (only one can be active)
        $radioLabel = Label::create("difficulty_label", "Difficulty:")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setSize(250, 20);
        $stack->addChild($radioLabel);

        // Horizontal stack for radio buttons
        $radioStack = StackPanel::create("radio_group")
            ->setOrientation(OrientationHelper::HORIZONTAL)
            ->setCustomSize(["100%", 30]);

        $easyRadio = Toggle::create("easy_radio")
            ->setToggleName("difficulty_easy")
            ->setRadioToggleGroup("difficulty_group")
            ->setToggleTabIndex(0)
            ->setToggleDefaultState(true)
            ->setSize(80, 25);
        $radioStack->addChild($easyRadio);

        $normalRadio = Toggle::create("normal_radio")
            ->setToggleName("difficulty_normal")
            ->setRadioToggleGroup("difficulty_group")
            ->setToggleTabIndex(1)
            ->setSize(80, 25);
        $radioStack->addChild($normalRadio);

        $hardRadio = Toggle::create("hard_radio")
            ->setToggleName("difficulty_hard")
            ->setRadioToggleGroup("difficulty_group")
            ->setToggleTabIndex(2)
            ->setSize(80, 25);
        $radioStack->addChild($hardRadio);

        $stack->addChild($radioStack);

        // Toggle with focus lost reset (reverts when leaving)
        $tempToggle = Toggle::create("temp_toggle")
            ->setToggleName("toggle_temporary")
            ->setResetOnFocusLost(true)
            ->setEnableDirectionalToggling(false)
            ->setSize(150, 30);
        $stack->addChild($tempToggle);

        $mainPanel->addChild($stack);
        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "toggle_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "TOGGLE_EXAMPLE";
    }
}
