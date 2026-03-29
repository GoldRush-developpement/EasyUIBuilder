<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\EditBox;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\StackPanel;
use refaltor\ui\helpers\OrientationHelper;

/**
 * EditBoxExample - Demonstrates EditBox (text input) configurations.
 *
 * Shows: basic text input, number-only input, placeholder text,
 *        max length, custom colors, locked state.
 */
class EditBoxExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $mainPanel = Panel::create("editbox_container")
            ->setSizePercentage(100, 100);

        // Background
        $bg = Image::create("editbox_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $mainPanel->addChild($bg);

        // Title
        $title = Label::create("editbox_title", "EditBox Examples")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $mainPanel->addChild($title);

        $stack = StackPanel::create("editbox_stack")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setSize(300, 250)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);

        // Username input
        $usernameLabel = Label::create("username_label", "Username:")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setSize(300, 18);
        $stack->addChild($usernameLabel);

        $usernameInput = EditBox::create("username_input")
            ->setTextBoxName("username_field")
            ->setPlaceHolderText("Enter your username...")
            ->setMaxLength(32)
            ->setTextType(EditBox::TEXT_TYPE_EXTENDED_ASCII)
            ->setTextColor(BasicColor::white())
            ->setSize(280, 25);
        $stack->addChild($usernameInput);

        // Number input (e.g., for a seed)
        $seedLabel = Label::create("seed_label", "World Seed:")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setSize(300, 18);
        $stack->addChild($seedLabel);

        $seedInput = EditBox::create("seed_input")
            ->setTextBoxName("seed_field")
            ->setPlaceHolderText("Enter seed number...")
            ->setMaxLength(20)
            ->setTextType(EditBox::TEXT_TYPE_NUMBER_CHARS)
            ->setTextColor(BasicColor::cyan())
            ->setSize(280, 25);
        $stack->addChild($seedInput);

        // Chat/message input with longer max length
        $messageLabel = Label::create("message_label", "Message:")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->setShadow()
            ->setSize(300, 18);
        $stack->addChild($messageLabel);

        $messageInput = EditBox::create("message_input")
            ->setTextBoxName("message_field")
            ->setPlaceHolderText("Type a message...")
            ->setMaxLength(256)
            ->setTextColor(BasicColor::white())
            ->setSize(280, 25);
        $stack->addChild($messageInput);

        // Locked/disabled input
        $lockedLabel = Label::create("locked_label", "Locked Field:")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::rgb(0.6, 0.6, 0.6))
            ->setSize(300, 18);
        $stack->addChild($lockedLabel);

        $lockedInput = EditBox::create("locked_input")
            ->setTextBoxName("locked_field")
            ->setPlaceHolderText("This field is locked")
            ->setEnabled(false)
            ->setLockedColor(BasicColor::rgb(0.4, 0.4, 0.4))
            ->setTextColor(BasicColor::rgb(0.6, 0.6, 0.6))
            ->setSize(280, 25);
        $stack->addChild($lockedInput);

        $mainPanel->addChild($stack);
        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "editbox_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "EDITBOX_EXAMPLE";
    }
}
