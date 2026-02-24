<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Button;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\StackPanel;
use refaltor\ui\elements\utils\CloseButton;
use refaltor\ui\elements\utils\PlayerRender;
use refaltor\ui\helpers\OrientationHelper;

/**
 * FullMenuExample - A complete game menu combining all elements.
 *
 * Demonstrates a real-world UI screen with:
 * - Background image
 * - Title label
 * - Player skin renderer
 * - Navigation buttons
 * - Close button
 * - Stack panel layout
 */
class FullMenuExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        // === Root panel ===
        $mainPanel = Panel::create("main_menu_panel")
            ->setSizePercentage(100, 100);

        // === Background image ===
        $background = Image::create("menu_background", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setKeepRatio(false)
            ->setLayer(-1);
        $mainPanel->addChild($background);

        // === Close button (top-right) ===
        $closeBtn = CloseButton::create("menu_close_button")
            ->setAnchorFrom(Element::ANCHOR_TOP_RIGHT)
            ->setAnchorTo(Element::ANCHOR_TOP_RIGHT)
            ->setOffset(-5, 5);
        $mainPanel->addChild($closeBtn);

        // === Title ===
        $title = Label::create("menu_title", "My Custom Menu")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setFontType(Label::TYPE_MINECRAFT_TEN)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 15);
        $mainPanel->addChild($title);

        // === Player render (left side) ===
        $playerRender = PlayerRender::create("player_skin")
            ->setSize(80, 120)
            ->setAnchorFrom(Element::ANCHOR_LEFT_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_LEFT_MIDDLE)
            ->setOffset(20, 0);
        $mainPanel->addChild($playerRender);

        // === Button menu (center, vertical stack) ===
        $buttonStack = StackPanel::create("button_stack")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setSize(200, 160)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->setOffset(0, 10);

        // Enable button factory
        $buttonStack->enableFactoryButton($root);

        // Play button
        $playBtn = Button::create("play_button", $root)
            ->setButtonText("Play")
            ->setVisibleIfTitle("Play")
            ->setSize(200, 30);
        $buttonStack->addChild($playBtn);

        // Shop button
        $shopBtn = Button::create("shop_button", $root)
            ->setButtonText("Shop")
            ->setVisibleIfTitle("Shop")
            ->setSize(200, 30);
        $buttonStack->addChild($shopBtn);

        // Settings button
        $settingsBtn = Button::create("settings_button", $root)
            ->setButtonText("Settings")
            ->setVisibleIfTitle("Settings")
            ->setSize(200, 30);
        $buttonStack->addChild($settingsBtn);

        $mainPanel->addChild($buttonStack);

        // === Footer label ===
        $footer = Label::create("footer_text", "Made with EasyUIBuilder v2.0")
            ->setFontSize(Label::FONT_SMALL)
            ->setColor(BasicColor::rgb(0.6, 0.6, 0.6))
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setOffset(0, -5);
        $mainPanel->addChild($footer);

        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "full_menu_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "FULL_MENU_EXAMPLE";
    }
}
