<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\components\Binding;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\StackPanel;
use refaltor\ui\helpers\OrientationHelper;

/**
 * BindingExample - Demonstrates the Binding system.
 *
 * Shows: global bindings, view bindings, collection bindings,
 *        visibility conditions, binding conditions, source control bindings.
 */
class BindingExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $mainPanel = Panel::create("binding_container")
            ->setSizePercentage(100, 100);

        // Background
        $bg = Image::create("binding_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $mainPanel->addChild($bg);

        // Title with global binding (reads #title_text from game)
        $title = Label::create("bound_title", "#title_text")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->addBinding(Binding::global("#title_text", "#title_text"))
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $mainPanel->addChild($title);

        $stack = StackPanel::create("binding_stack")
            ->setOrientation(OrientationHelper::VERTICAL)
            ->setSize(300, 220)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);

        // Label with global binding to player name
        $playerName = Label::create("player_name_label", "#localplayername")
            ->setFontSize(Label::FONT_LARGE)
            ->setColor(BasicColor::cyan())
            ->setShadow()
            ->addBinding(Binding::global("#localplayername"))
            ->setSize(300, 25);
        $stack->addChild($playerName);

        // Panel visible only when a certain condition is true (view binding)
        $conditionalPanel = Panel::create("conditional_panel")
            ->setSize(280, 30)
            ->addBinding(Binding::visibility("(#title_text = 'BINDING_EXAMPLE')"));

        $conditionalLabel = Label::create("conditional_label", "Visible only when title matches!")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::green())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $conditionalPanel->addChild($conditionalLabel);
        $stack->addChild($conditionalPanel);

        // Label with collection binding (form buttons example)
        $collectionLabel = Label::create("collection_label", "#form_button_text")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::white())
            ->addBinding(
                Binding::collection("#form_button_text", "form_buttons")
            )
            ->addBinding(
                Binding::collectionDetails("form_buttons")
            )
            ->setSize(300, 25);
        $stack->addChild($collectionLabel);

        // View binding with source control (reads from another element)
        $sourcePanel = Panel::create("source_data_panel")
            ->setSize(280, 25);

        $sourceLabel = Label::create("source_bound_label", "Bound from source")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::magenta())
            ->addBinding(
                (new Binding())
                    ->setBindingType(Binding::TYPE_VIEW)
                    ->setSourceControlName("player_name_label")
                    ->setSourcePropertyName("#localplayername")
                    ->setTargetPropertyName("#text")
            )
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $sourcePanel->addChild($sourceLabel);
        $stack->addChild($sourcePanel);

        // Binding with condition (only updates once)
        $onceLabel = Label::create("once_bound_label", "#online_player_count")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::rgb(1.0, 0.5, 0.0))
            ->addBinding(
                Binding::global("#online_player_count")
                    ->setBindingCondition(Binding::CONDITION_ONCE)
            )
            ->setSize(300, 25);
        $stack->addChild($onceLabel);

        // Shorthand visibility using setVisible()
        $visiblePanel = Panel::create("shorthand_visible")
            ->setSize(280, 30)
            ->setVisible("(not (#is_creative_mode))");

        $visibleLabel = Label::create("survival_only", "Only visible in Survival!")
            ->setFontSize(Label::FONT_NORMAL)
            ->setColor(BasicColor::red())
            ->setShadow()
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $visiblePanel->addChild($visibleLabel);
        $stack->addChild($visiblePanel);

        $mainPanel->addChild($stack);
        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "binding_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "BINDING_EXAMPLE";
    }
}
