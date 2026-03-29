<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\ScrollView;
use refaltor\ui\elements\StackPanel;
use refaltor\ui\helpers\OrientationHelper;

/**
 * ScrollViewExample - Demonstrates ScrollView configurations.
 *
 * Shows: vertical scrolling, horizontal scrolling, scroll speed,
 *        touch mode, jump to bottom, scrollbar controls.
 */
class ScrollViewExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $mainPanel = Panel::create("scroll_container")
            ->setSizePercentage(100, 100);

        // Background
        $bg = Image::create("scroll_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $mainPanel->addChild($bg);

        // Title
        $title = Label::create("scroll_title", "ScrollView Examples")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $mainPanel->addChild($title);

        // Vertical scroll view with many items
        $verticalScroll = ScrollView::create("vertical_scroll")
            ->setOrientation(ScrollView::ORIENTATION_VERTICAL)
            ->setScrollSpeed(1.5)
            ->setTouchMode(true)
            ->setAlwaysListenToInput(true)
            ->setSize(250, 180)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->setOffset(-80, 10);

        // Content: a stack of labels (simulating a long list)
        $scrollContent = StackPanel::create("scroll_content_stack")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setCustomSize(["100%", "default"]);

        for ($i = 1; $i <= 20; $i++) {
            $item = Label::create("scroll_item_$i", "Item #$i - Scrollable content line")
                ->setFontSize(Label::FONT_NORMAL)
                ->setColor(BasicColor::white())
                ->setShadow()
                ->setSize(240, 20);
            $scrollContent->addChild($item);
        }

        $verticalScroll->addChild($scrollContent);
        $mainPanel->addChild($verticalScroll);

        // Horizontal scroll view
        $horizontalScroll = ScrollView::create("horizontal_scroll")
            ->setOrientation(ScrollView::ORIENTATION_HORIZONTAL)
            ->setScrollSpeed(2.0)
            ->setTouchMode(true)
            ->setSize(250, 60)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->setOffset(80, 10);

        $hContent = StackPanel::create("h_scroll_content")
            ->setOrientation(OrientationHelper::HORIZONTAL)
            ->setCustomSize(["default", "100%"]);

        for ($i = 1; $i <= 10; $i++) {
            $color = BasicColor::randomPastelColor();
            $card = Panel::create("card_$i")
                ->setSize(80, 50);

            $cardLabel = Label::create("card_label_$i", "Card $i")
                ->setFontSize(Label::FONT_SMALL)
                ->setColor($color)
                ->setShadow()
                ->setAnchorFrom(Element::ANCHOR_CENTER)
                ->setAnchorTo(Element::ANCHOR_CENTER);
            $card->addChild($cardLabel);

            $hContent->addChild($card);
        }

        $horizontalScroll->addChild($hContent);
        $mainPanel->addChild($horizontalScroll);

        // Chat-like scroll view (jumps to bottom on update)
        $chatScroll = ScrollView::create("chat_scroll")
            ->setOrientation(ScrollView::ORIENTATION_VERTICAL)
            ->setJumpToBottomOnUpdate(true)
            ->setScrollSpeed(1.0)
            ->setTouchMode(true)
            ->setSize(200, 100)
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setOffset(0, -10);

        $chatContent = StackPanel::create("chat_content")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setCustomSize(["100%", "default"]);

        $messages = ["Player1: Hello!", "Player2: Hey there", "Player1: GG", "Server: Welcome!", "Player3: Hi all"];
        foreach ($messages as $idx => $msg) {
            $chatLine = Label::create("chat_$idx", $msg)
                ->setFontSize(Label::FONT_SMALL)
                ->setColor(BasicColor::white())
                ->setSize(190, 16);
            $chatContent->addChild($chatLine);
        }

        $chatScroll->addChild($chatContent);
        $mainPanel->addChild($chatScroll);

        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "scrollview_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "SCROLLVIEW_EXAMPLE";
    }
}
