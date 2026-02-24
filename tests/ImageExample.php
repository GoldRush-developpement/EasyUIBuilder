<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Panel;

/**
 * ImageExample - Demonstrates Image element features.
 *
 * Shows: tiling, nineslice, UV mapping, grayscale, fill, keep ratio.
 */
class ImageExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $panel = Panel::create("image_container")
            ->setSizePercentage(100, 100);

        // Simple image with nineslice
        $ninesliceImg = Image::create("nineslice_image", "textures/ui/dialog_background_opaque")
            ->setNinesliceSize(4)
            ->setSize(200, 150)
            ->setAnchorFrom(Element::ANCHOR_TOP_LEFT)
            ->setAnchorTo(Element::ANCHOR_TOP_LEFT)
            ->setOffset(10, 10);
        $panel->addChild($ninesliceImg);

        // Tiled image
        $tiledImg = Image::create("tiled_image", "textures/ui/grid_pattern")
            ->setTiled(true)
            ->setTiledScale([2.0, 2.0])
            ->setSize(150, 150)
            ->setAnchorFrom(Element::ANCHOR_TOP_RIGHT)
            ->setAnchorTo(Element::ANCHOR_TOP_RIGHT)
            ->setOffset(-10, 10);
        $panel->addChild($tiledImg);

        // Image with UV mapping (sprite sheet crop)
        $uvImage = Image::create("uv_image", "textures/ui/icons")
            ->setUv([16, 16])
            ->setUvSize([16, 16])
            ->setSize(64, 64)
            ->setKeepRatio(true)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $panel->addChild($uvImage);

        // Grayscale image
        $grayImg = Image::create("gray_image", "textures/ui/world_screenshot")
            ->setGrayscale(true)
            ->setSize(120, 80)
            ->setKeepRatio(true)
            ->setBilinear(true)
            ->setAnchorFrom(Element::ANCHOR_BOTTOM_LEFT)
            ->setAnchorTo(Element::ANCHOR_BOTTOM_LEFT)
            ->setOffset(10, -10);
        $panel->addChild($grayImg);

        // Fill image (stretches to container)
        $fillImg = Image::create("fill_image", "textures/ui/panorama_overlay")
            ->setFill(true)
            ->setKeepRatio(false)
            ->setSizePercentage(100, 100)
            ->setLayer(-1);
        $panel->addChild($fillImg);

        $root->addElement($panel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "image_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "IMAGE_EXAMPLE";
    }
}
