<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\components\Animation;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;

/**
 * AnimationExample - Demonstrates the Animation system.
 *
 * Shows: fade in/out, slide in, pulse, chained animations, easings,
 *        flip book, color animation, wait animation, clip animation.
 */
class AnimationExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        // === Define animations at namespace level ===

        // Fade in animation
        $fadeIn = Animation::fadeIn("@anim_fade_in", 0.5);
        $root->addAnimation($fadeIn);

        // Fade out animation
        $fadeOut = Animation::fadeOut("@anim_fade_out", 0.3);
        $root->addAnimation($fadeOut);

        // Slide in from left
        $slideLeft = Animation::slideIn("@anim_slide_from_left", [-200, 0], 0.4, Animation::EASING_OUT_BACK);
        $root->addAnimation($slideLeft);

        // Slide in from top
        $slideTop = Animation::slideIn("@anim_slide_from_top", [0, -100], 0.3, Animation::EASING_OUT_CUBIC);
        $root->addAnimation($slideTop);

        // Pulse size animation
        $pulse = Animation::pulse("@anim_pulse", [100, 30], [110, 34], 0.8)
            ->setReversible(true);
        $root->addAnimation($pulse);

        // Color cycle animation
        $colorCycle = Animation::create("@anim_color_cycle", Animation::TYPE_COLOR)
            ->setFrom([1.0, 0.0, 0.0])
            ->setTo([0.0, 0.0, 1.0])
            ->setDuration(2.0)
            ->setEasing(Animation::EASING_IN_OUT_SINE)
            ->setReversible(true);
        $root->addAnimation($colorCycle);

        // Chained animation: fade in, then wait, then fade out
        $chainFadeIn = Animation::create("@anim_chain_fade_in", Animation::TYPE_ALPHA)
            ->setFrom(0.0)
            ->setTo(1.0)
            ->setDuration(0.5)
            ->setNext("@anim_chain_wait");
        $root->addAnimation($chainFadeIn);

        $chainWait = Animation::create("@anim_chain_wait", Animation::TYPE_WAIT)
            ->setDuration(2.0)
            ->setNext("@anim_chain_fade_out");
        $root->addAnimation($chainWait);

        $chainFadeOut = Animation::create("@anim_chain_fade_out", Animation::TYPE_ALPHA)
            ->setFrom(1.0)
            ->setTo(0.0)
            ->setDuration(0.5)
            ->setDestroyAtEnd(true);
        $root->addAnimation($chainFadeOut);

        // Clip animation (progress bar style)
        $clipAnim = Animation::create("@anim_clip_progress", Animation::TYPE_CLIP)
            ->setFrom(0.0)
            ->setTo(1.0)
            ->setDuration(3.0)
            ->setEasing(Animation::EASING_LINEAR);
        $root->addAnimation($clipAnim);

        // Bounce in easing
        $bounceIn = Animation::create("@anim_bounce_in", Animation::TYPE_OFFSET)
            ->setFrom([0, -50])
            ->setTo([0, 0])
            ->setDuration(0.6)
            ->setEasing(Animation::EASING_OUT_BOUNCE);
        $root->addAnimation($bounceIn);

        // Elastic offset
        $elastic = Animation::create("@anim_elastic", Animation::TYPE_OFFSET)
            ->setFrom([100, 0])
            ->setTo([0, 0])
            ->setDuration(1.0)
            ->setEasing(Animation::EASING_OUT_ELASTIC);
        $root->addAnimation($elastic);

        // === UI elements using the animations ===

        $mainPanel = Panel::create("anim_container")
            ->setSizePercentage(100, 100)
            ->addAnim("@anim_fade_in");

        // Background
        $bg = Image::create("anim_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $mainPanel->addChild($bg);

        // Title slides in from top
        $title = Label::create("anim_title", "Animation Examples")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->addAnim("@anim_slide_from_top")
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $mainPanel->addChild($title);

        // Panel that slides from left
        $slidePanel = Panel::create("sliding_panel")
            ->setSize(200, 40)
            ->addAnim("@anim_slide_from_left")
            ->setAnchorFrom(Element::ANCHOR_LEFT_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_LEFT_MIDDLE)
            ->setOffset(20, -40);

        $slideLabel = Label::create("slide_text", "I slide from the left!")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::cyan())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $slidePanel->addChild($slideLabel);
        $mainPanel->addChild($slidePanel);

        // Pulsing button label
        $pulseLabel = Label::create("pulse_text", "I'm pulsing!")
            ->setFontSize(Label::FONT_LARGE)
            ->setColor(BasicColor::green())
            ->setShadow()
            ->addAnim("@anim_pulse")
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->setOffset(0, 0);
        $mainPanel->addChild($pulseLabel);

        // Color cycling label
        $colorLabel = Label::create("color_cycle_text", "Color cycling!")
            ->setFontSize(Label::FONT_LARGE)
            ->setShadow()
            ->addAnim("@anim_color_cycle")
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->setOffset(0, 40);
        $mainPanel->addChild($colorLabel);

        // Chained animation: appears, waits, then disappears
        $chainLabel = Label::create("chain_text", "I appear, wait, then vanish!")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::magenta())
            ->setShadow()
            ->addAnim("@anim_chain_fade_in")
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setOffset(0, -60);
        $mainPanel->addChild($chainLabel);

        // Bounce in element
        $bounceLabel = Label::create("bounce_text", "Bounce in!")
            ->setFontSize(Label::FONT_LARGE)
            ->setColor(BasicColor::rgb(1.0, 0.5, 0.0))
            ->setShadow()
            ->addAnim("@anim_bounce_in")
            ->setAnchorFrom(Element::ANCHOR_RIGHT_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_RIGHT_MIDDLE)
            ->setOffset(-20, -30);
        $mainPanel->addChild($bounceLabel);

        // Elastic element
        $elasticLabel = Label::create("elastic_text", "Elastic!")
            ->setFontSize(Label::FONT_LARGE)
            ->setColor(BasicColor::red())
            ->setShadow()
            ->addAnim("@anim_elastic")
            ->setAnchorFrom(Element::ANCHOR_RIGHT_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_RIGHT_MIDDLE)
            ->setOffset(-20, 20);
        $mainPanel->addChild($elasticLabel);

        // Progress bar with clip animation
        $progressBg = Image::create("progress_bg", "textures/ui/loading_bar_empty")
            ->setSize(200, 10)
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setOffset(0, -30);
        $mainPanel->addChild($progressBg);

        $progressFill = Image::create("progress_fill", "textures/ui/loading_bar_full")
            ->setSize(200, 10)
            ->addAnim("@anim_clip_progress")
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setOffset(0, -30);
        $mainPanel->addChild($progressFill);

        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "animation_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "ANIMATION_EXAMPLE";
    }
}
