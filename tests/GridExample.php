<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Grid;
use refaltor\ui\elements\Panel;

/**
 * GridExample - Demonstrates Grid element features.
 *
 * Shows: grid dimensions, item templates, maximum items, fill direction.
 */
class GridExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        $panel = Panel::create("grid_container")
            ->setSizePercentage(100, 100);

        // Basic 3x3 grid
        $grid = Grid::create("inventory_grid")
            ->setGridDimensions([3, 3])
            ->setMaximumGridItems(9)
            ->setGridItemTemplate("common.inventory_slot")
            ->setGridFillDirection("horizontal")
            ->setGridRescalingType("horizontal")
            ->setSize(180, 180)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER);
        $panel->addChild($grid);

        // Vertical grid for a list layout
        $listGrid = Grid::create("list_grid")
            ->setGridDimensions([1, 5])
            ->setMaximumGridItems(5)
            ->setGridFillDirection("vertical")
            ->setSize(200, 250)
            ->setAnchorFrom(Element::ANCHOR_RIGHT_MIDDLE)
            ->setAnchorTo(Element::ANCHOR_RIGHT_MIDDLE)
            ->setOffset(-10, 0);
        $panel->addChild($listGrid);

        $root->addElement($panel);

        return $root;
    }

    public function getNamespace(): string
    {
        return "grid_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "GRID_EXAMPLE";
    }
}
