<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\InputPanel;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;

/**
 * InputPanelExample - Demonstrates InputPanel configurations.
 *
 * Shows: modal input panel, focus navigation, button mappings,
 *        gesture tracking, always handle pointer.
 */
class InputPanelExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $mainPanel = Panel::create("input_panel_container")
            ->setSizePercentage(100, 100);

        // Background
        $bg = Image::create("input_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $mainPanel->addChild($bg);

        // Title
        $title = Label::create("input_title", "InputPanel Examples")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $mainPanel->addChild($title);

        // Modal input panel (blocks input to elements behind)
        $modalPanel = InputPanel::create("modal_dialog")
            ->setModal(true)
            ->setAlwaysListenToInput(true)
            ->setFocusEnabled(true)
            ->setFocusIdentifier("modal_focus")
            ->setDefaultFocusPrecedence(true)
            ->addButtonMapping("button.menu_cancel", "button.menu_exit", "pressed")
            ->addButtonMapping("button.menu_select", "button.menu_ok", "pressed")
            ->setSize(250, 180)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);

        $modalLabel = Label::create("modal_label", "This is a modal dialog")
            ->setFontSize(Label::FONT_LARGE)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $modalPanel->addChild($modalLabel);

        $mainPanel->addChild($modalPanel);

        // Non-modal input panel with focus navigation
        $navPanel = InputPanel::create("nav_panel")
            ->setModal(false)
            ->setFocusEnabled(true)
            ->setFocusIdentifier("nav_focus")
            ->setFocusChangeUp("button_above")
            ->setFocusChangeDown("button_below")
            ->setFocusChangeLeft("button_left")
            ->setFocusChangeRight("button_right")
            ->setUseLastFocus(true)
            ->setSize(200, 60)
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_LEFT)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_LEFT)
            ->setOffset(10, -10);

        $navLabel = Label::create("nav_label", "Focusable Panel")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::cyan())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $navPanel->addChild($navLabel);

        $mainPanel->addChild($navPanel);

        // Gesture tracking panel (for touch/drag interactions)
        $gesturePanel = InputPanel::create("gesture_panel")
            ->setModal(false)
            ->setGestureTrackingButton(true)
            ->setAlwaysHandlePointer(true)
            ->setAlwaysListenToInput(true)
            ->setSize(200, 60)
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_RIGHT)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_RIGHT)
            ->setOffset(-10, -10);

        $gestureLabel = Label::create("gesture_label", "Touch/Drag Area")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::green())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $gesturePanel->addChild($gestureLabel);

        $mainPanel->addChild($gesturePanel);

        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "inputpanel_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "INPUTPANEL_EXAMPLE";
    }
}
