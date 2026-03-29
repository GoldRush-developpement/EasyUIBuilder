<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\Screen;

/**
 * ScreenExample - Demonstrates Screen element configurations.
 *
 * Shows: screen render flags, modal screens, input absorption,
 *        game rendering behind UI, close on player hurt.
 */
class ScreenExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        // Standard modal screen (blocks game behind)
        $modalScreen = Screen::create("modal_screen")
            ->setRenderOnlyWhenTopMost(true)
            ->setRenderGameBehind(false)
            ->setAbsorbInput(true)
            ->setIsShowingMenu(true)
            ->setIsModal(true)
            ->setLowFreqRendering(true)
            ->setSizePercentage(100, 100);

        $modalBg = Image::create("modal_screen_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $modalScreen->addChild($modalBg);

        $modalTitle = Label::create("modal_screen_title", "Modal Screen (blocks game)")
            ->setFontSize(Label::FONT_LARGE)
            ->setShadow()
            ->setColor(BasicColor::red())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 20);
        $modalScreen->addChild($modalTitle);

        $root->addElement($modalScreen);

        // HUD overlay screen (game visible behind)
        $hudScreen = Screen::create("hud_overlay")
            ->setRenderOnlyWhenTopMost(false)
            ->setRenderGameBehind(true)
            ->setAbsorbInput(false)
            ->setIsShowingMenu(false)
            ->setIsModal(false)
            ->setForceRenderBelow(true)
            ->setSizePercentage(100, 100);

        $hudLabel = Label::create("hud_info", "HUD Overlay - Game visible behind")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::green())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_TOP_LEFT)
            ->setAnchorTo(Element::ANCHOR_TOP_LEFT)
            ->setOffset(5, 5);
        $hudScreen->addChild($hudLabel);

        $root->addElement($hudScreen);

        // Screen that closes when player takes damage
        $fragileScreen = Screen::create("fragile_screen")
            ->setCloseOnPlayerHurt(true)
            ->setRenderGameBehind(true)
            ->setIsModal(false)
            ->setAbsorbInput(true)
            ->setSizePercentage(100, 100);

        $fragileLabel = Label::create("fragile_info", "This screen closes if you take damage!")
            ->setFontSize(Label::FONT_LARGE)
            ->setColor(BasicColor::yellow())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $fragileScreen->addChild($fragileLabel);

        $root->addElement($fragileScreen);

        // Cached screen (kept in memory for fast re-opening)
        $cachedScreen = Screen::create("cached_screen")
            ->setCacheScreen(true)
            ->setRenderOnlyWhenTopMost(true)
            ->setRenderGameBehind(false)
            ->setIsModal(true)
            ->setShouldStealMouse(true)
            ->setSizePercentage(100, 100);

        $cachedLabel = Label::create("cached_info", "Cached & Mouse-Stealing Screen")
            ->setFontSize(Label::FONT_LARGE)
            ->setColor(BasicColor::magenta())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $cachedScreen->addChild($cachedLabel);

        $root->addElement($cachedScreen);

        return $root;
    }

    public function getNamespace(): string
    {
        return "screen_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "SCREEN_EXAMPLE";
    }
}
