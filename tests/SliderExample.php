<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\Slider;
use refaltor\ui\elements\StackPanel;
use refaltor\ui\helpers\OrientationHelper;

/**
 * SliderExample - Demonstrates Slider element configurations.
 *
 * Shows: horizontal slider, vertical slider, step configuration,
 *        custom box/track controls, speed settings.
 */
class SliderExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $mainPanel = Panel::create("slider_container")
            ->setSizePercentage(100, 100);

        // Background
        $bg = Image::create("slider_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $mainPanel->addChild($bg);

        // Title
        $title = Label::create("slider_title", "Slider Examples")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $mainPanel->addChild($title);

        $stack = StackPanel::create("slider_stack")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setSize(300, 250)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);

        // Volume slider - horizontal with fine steps
        $volumeLabel = Label::create("volume_label", "Volume")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setSize(300, 20);
        $stack->addChild($volumeLabel);

        $volumeSlider = Slider::create("volume_slider")
            ->setSliderName("slider_volume")
            ->setSliderDirection("horizontal")
            ->setSliderSteps(20)
            ->setDefaultControlValue(0.8)
            ->setSliderTrackButton("button.menu_select")
            ->setSliderSelectOnHover(true)
            ->setSize(280, 20);
        $stack->addChild($volumeSlider);

        // Brightness slider - with custom controls
        $brightnessLabel = Label::create("brightness_label", "Brightness")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setSize(300, 20);
        $stack->addChild($brightnessLabel);

        $brightnessSlider = Slider::create("brightness_slider")
            ->setSliderName("slider_brightness")
            ->setSliderSteps(10)
            ->setDefaultControlValue(0.5)
            ->setBackgroundControl("slider_bg_control")
            ->setBackgroundHoverControl("slider_bg_hover_control")
            ->setProgressControl("slider_progress_control")
            ->setSliderBoxControl("slider_thumb")
            ->setSliderBoxHoverControl("slider_thumb_hover")
            ->setSize(280, 20);
        $stack->addChild($brightnessSlider);

        // FOV slider - with increase/decrease buttons
        $fovLabel = Label::create("fov_label", "Field of View")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setSize(300, 20);
        $stack->addChild($fovLabel);

        $fovSlider = Slider::create("fov_slider")
            ->setSliderName("slider_fov")
            ->setSliderSteps(30)
            ->setDefaultControlValue(0.5)
            ->setSliderSmallDecreaseButton("button.menu_left")
            ->setSliderSmallIncreaseButton("button.menu_right")
            ->setSliderTimeout(0.3)
            ->setSize(280, 20);
        $stack->addChild($fovSlider);

        // Vertical slider (e.g., a vertical volume bar)
        $verticalSlider = Slider::create("vertical_slider")
            ->setSliderName("slider_vertical")
            ->setSliderDirection("vertical")
            ->setSliderSteps(10)
            ->setDefaultControlValue(0.5)
            ->setSize(20, 120)
            ->setAnchorFrom(Element::ANCHOR_RIGHT_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_RIGHT_MIDDLE)
            ->setOffset(-20, 0);
        $mainPanel->addChild($verticalSlider);

        $mainPanel->addChild($stack);
        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "slider_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "SLIDER_EXAMPLE";
    }
}
