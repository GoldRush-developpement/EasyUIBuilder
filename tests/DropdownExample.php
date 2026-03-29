<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Dropdown;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\StackPanel;
use refaltor\ui\helpers\OrientationHelper;

/**
 * DropdownExample - Demonstrates Dropdown element configurations.
 *
 * Shows: basic dropdown, dropdown with items, dropdown area,
 *        scroll content panel, naming.
 */
class DropdownExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $mainPanel = Panel::create("dropdown_container")
            ->setSizePercentage(100, 100);

        // Background
        $bg = Image::create("dropdown_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $mainPanel->addChild($bg);

        // Title
        $title = Label::create("dropdown_title", "Dropdown Examples")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $mainPanel->addChild($title);

        $stack = StackPanel::create("dropdown_stack")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setSize(300, 200)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);

        // Game mode dropdown
        $gamemodeLabel = Label::create("gamemode_label", "Game Mode:")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setSize(300, 20);
        $stack->addChild($gamemodeLabel);

        $gamemodeDropdown = Dropdown::create("gamemode_dropdown")
            ->setDropdownName("dropdown_gamemode")
            ->setDropdownContentControl("gamemode_content")
            ->setDropdownArea("gamemode_area")
            ->addDropdownItem("Survival", "0")
            ->addDropdownItem("Creative", "1")
            ->addDropdownItem("Adventure", "2")
            ->addDropdownItem("Spectator", "3")
            ->setSize(280, 25);
        $stack->addChild($gamemodeDropdown);

        // Difficulty dropdown
        $difficultyLabel = Label::create("difficulty_dropdown_label", "Difficulty:")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setSize(300, 20);
        $stack->addChild($difficultyLabel);

        $difficultyDropdown = Dropdown::create("difficulty_dropdown")
            ->setDropdownName("dropdown_difficulty")
            ->setDropdownContentControl("difficulty_content")
            ->addDropdownItem("Peaceful", "0")
            ->addDropdownItem("Easy", "1")
            ->addDropdownItem("Normal", "2")
            ->addDropdownItem("Hard", "3")
            ->setSize(280, 25);
        $stack->addChild($difficultyDropdown);

        // Language dropdown with scroll
        $langLabel = Label::create("lang_label", "Language:")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setSize(300, 20);
        $stack->addChild($langLabel);

        $langDropdown = Dropdown::create("language_dropdown")
            ->setDropdownName("dropdown_language")
            ->setDropdownContentControl("language_content")
            ->setDropdownScrollContentPanel("language_scroll_panel")
            ->addDropdownItem("English", "en")
            ->addDropdownItem("French", "fr")
            ->addDropdownItem("Spanish", "es")
            ->addDropdownItem("German", "de")
            ->addDropdownItem("Japanese", "ja")
            ->addDropdownItem("Chinese", "zh")
            ->addDropdownItem("Korean", "ko")
            ->addDropdownItem("Portuguese", "pt")
            ->setSize(280, 25);
        $stack->addChild($langDropdown);

        $mainPanel->addChild($stack);
        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "dropdown_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "DROPDOWN_EXAMPLE";
    }
}
