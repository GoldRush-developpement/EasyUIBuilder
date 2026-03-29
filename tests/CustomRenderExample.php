<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\CustomRender;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;

/**
 * CustomRenderExample - Demonstrates CustomRender element configurations.
 *
 * Shows: paper doll renderer, inventory item renderer, gradient renderer,
 *        name tag renderer, panorama renderer with property bags.
 */
class CustomRenderExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $mainPanel = Panel::create("render_container")
            ->setSizePercentage(100, 100);

        // Background
        $bg = Image::create("render_bg", "textures/ui/dialog_background_opaque")
            ->setSizePercentage(100, 100)
            ->setNinesliceSize(4)
            ->setLayer(-1);
        $mainPanel->addChild($bg);

        // Title
        $title = Label::create("render_title", "Custom Render Examples")
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setShadow()
            ->setColor(BasicColor::yellow())
            ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
            ->setOffset(0, 10);
        $mainPanel->addChild($title);

        // Paper doll renderer (3D player model)
        $paperDoll = CustomRender::create("player_doll", CustomRender::RENDERER_PAPER_DOLL)
            ->addProperty("#entity_type", "player")
            ->addProperty("#camera_rotation", [20.0, -20.0])
            ->addProperty("#camera_tilt", [0.0, 0.0])
            ->setSize(100, 140)
            ->setAnchorFrom(Element::ANCHOR_LEFT_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_LEFT_MIDDLE)
            ->setOffset(20, 0);
        $mainPanel->addChild($paperDoll);

        // Inventory item renderer (shows an item in 3D)
        $itemRender = CustomRender::create("item_display", CustomRender::RENDERER_INVENTORY_ITEM)
            ->addProperty("#item_id_aux", 1)
            ->setColor([1.0, 1.0, 1.0, 1.0])
            ->setSize(48, 48)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->setOffset(0, -40);
        $mainPanel->addChild($itemRender);

        $itemLabel = Label::create("item_label", "Inventory Item Renderer")
            ->setFontSize(Label::FONT_SMALL)
            ->setColor(BasicColor::white())
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->setOffset(0, -10);
        $mainPanel->addChild($itemLabel);

        // Gradient renderer (background gradients)
        $gradient = CustomRender::create("bg_gradient", CustomRender::RENDERER_GRADIENT)
            ->addProperty("#gradient_color_1", [0.0, 0.0, 0.0, 0.8])
            ->addProperty("#gradient_color_2", [0.0, 0.0, 0.2, 0.4])
            ->addProperty("#gradient_direction", "vertical")
            ->setSize(200, 100)
            ->setAnchorFrom(Element::ANCHOR_RIGHT_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_RIGHT_MIDDLE)
            ->setOffset(-20, -30);
        $mainPanel->addChild($gradient);

        $gradientLabel = Label::create("gradient_label", "Gradient Renderer")
            ->setFontSize(Label::FONT_SMALL)
            ->setColor(BasicColor::cyan())
            ->setAnchorFrom(Element::ANCHOR_RIGHT_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_RIGHT_MIDDLE)
            ->setOffset(-70, 30);
        $mainPanel->addChild($gradientLabel);

        // Name tag renderer
        $nameTag = CustomRender::create("player_nametag", CustomRender::RENDERER_NAME_TAG)
            ->addProperty("#playername", "Steve")
            ->setEnableProfanityFilter(true)
            ->setPrimaryColor("white")
            ->setSize(120, 20)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->setOffset(0, 40);
        $mainPanel->addChild($nameTag);

        // Vignette renderer (screen edge darkening)
        $vignette = CustomRender::create("screen_vignette", CustomRender::RENDERER_VIGNETTE)
            ->setColor([0.0, 0.0, 0.0, 0.5])
            ->setSizePercentage(100, 100)
            ->setLayer(10);
        $mainPanel->addChild($vignette);

        // Splash text renderer
        $splash = CustomRender::create("splash_text", CustomRender::RENDERER_SPLASH_TEXT)
            ->addProperty("#splash_text", "EasyUIBuilder is awesome!")
            ->setColor([1.0, 1.0, 0.0, 1.0])
            ->setSize(200, 30)
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_MIDDLE)
            ->setOffset(0, -15);
        $mainPanel->addChild($splash);

        $root->addElement($mainPanel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "customrender_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "CUSTOMRENDER_EXAMPLE";
    }
}
