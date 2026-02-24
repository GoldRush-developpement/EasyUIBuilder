![logo](img/logo.png)

# EasyUIBuilder v2.0.0

![PHP 8.0+](https://img.shields.io/badge/PHP-8.0%2B-777BB4?logo=php&logoColor=white)
![Version](https://img.shields.io/badge/version-2.0.0-blue)
![License](https://img.shields.io/badge/license-MIT-green)

A PHP library for generating **Minecraft Bedrock Edition JSON UI** files using a fluent builder pattern. Build labels, panels, buttons, images, grids, and stack panels with clean, readable code — and output Minecraft-compatible resource packs automatically.

---

## Features

- **Fluent API** — chainable methods for all UI elements
- **Auto-generation** of `_ui_defs.json` and `server_form.json`
- **All Bedrock UI types** — Label, Panel, Button, Image, Grid, StackPanel
- **Utility elements** — CloseButton, PlayerRender (pre-built components)
- **Color utilities** — predefined colors, RGB, random, pastel, complementary
- **Anchoring system** — 9-point anchor positioning with offsets
- **Sizing modes** — pixel, percentage, custom array sizes
- **RootBuild system** — register screen definitions and auto-generate packs

---

## Installation

**Requirements:** PHP 8.0 or higher

### Via Composer

```bash
composer require refaltor/easy-ui-builder
```

### Manual

Clone the repository and include the autoloader:

```php
spl_autoload_register(function (string $classname): void {
    if (str_contains($classname, "refaltor\\")) {
        require_once("./src/" . str_replace("\\", "/", $classname) . ".php");
    }
});
```

---

## Quick Start

```php
use refaltor\ui\builders\Root;
use refaltor\ui\elements\Label;
use refaltor\ui\colors\BasicColor;

$root = Root::create("my_namespace");
$root->addElement(
    Label::create("hello", "Hello Minecraft!")
        ->setFontSize(Label::FONT_EXTRA_LARGE)
        ->setShadow()
        ->setColor(BasicColor::yellow())
);
$root->generateAndSaveJson("ui/my_screen.json");
```

---

## API Reference

### Root

The top-level container for a UI screen.

```php
$root = Root::create("namespace_name");
$root->addElement($element);         // Add a single element
$root->addElements([$el1, $el2]);    // Add multiple elements
$root->generateAndSaveJson("path"); // Save to JSON file
$root->setTitleCondition("TITLE");   // Set visibility condition
```

### Element (Base Class)

All UI elements inherit from `Element`. Common methods:

```php
$element->setAnchorFrom(Element::ANCHOR_CENTER);   // Anchor origin
$element->setAnchorTo(Element::ANCHOR_CENTER);      // Anchor target
$element->setOffset(10, -5);                         // X, Y offset
$element->setSize(200, 100);                         // Width, Height (pixels)
$element->setSizePercentage(50, 100);                // Width%, Height%
$element->setSizePixel(100, 50);                     // Pixel size
$element->setCustomSize(["100%", "50px"]);           // Mixed sizing
$element->setLayer(2);                               // Z-layer
$element->setAlpha(0.8);                             // Transparency
$element->addChild($otherElement);                   // Nest elements
$element->addChilds([$el1, $el2]);                   // Nest multiple
$element->enableFactoryButton($root);                // Enable button factory
```

**Anchor constants:**
| Constant | Value |
|---|---|
| `ANCHOR_TOP_LEFT` | `top_left` |
| `ANCHOR_TOP_MIDDLE` | `top_middle` |
| `ANCHOR_TOP_RIGHT` | `top_right` |
| `ANCHOR_LEFT_MIDDLE` | `left_middle` |
| `ANCHOR_CENTER` | `center` |
| `ANCHOR_RIGHT_MIDDLE` | `right_middle` |
| `ANCHOR_BOTTOM_LEFT` | `bottom_left` |
| `ANCHOR_BOTTOM_MIDDLE` | `bottom_middle` |
| `ANCHOR_BOTTOM_RIGHT` | `bottom_right` |

### Label

Text element with font customization.

```php
$label = Label::create("name", "Display text");
$label->setFontSize(Label::FONT_EXTRA_LARGE);  // FONT_SMALL, FONT_NORMAL, FONT_LARGE, FONT_EXTRA_LARGE
$label->setFontType(Label::TYPE_MINECRAFT_TEN); // TYPE_DEFAULT, TYPE_RUNE, TYPE_UNICODE, TYPE_SMOOTH, TYPE_MINECRAFT_TEN
$label->setFontScaleFactor(2.0);                // Scale multiplier
$label->setShadow();                            // Enable text shadow
$label->setColor(BasicColor::red());            // Set text color
```

### Panel

Container element for grouping and layout.

```php
$panel = Panel::create("name");
// Inherits all Element methods plus:
// visible, enabled, alpha, propagateAlpha, clipsChildren, allowClipping,
// clipOffset, enableScissorTest, propertyBag, anims, variables...
```

### Button

Interactive button element. Requires `enableFactoryButton($root)` on the parent.

```php
$button = Button::create("name", $root);
$button->setButtonText("Click Me");
$button->setVisibleIfTitle("Click Me");                      // Visibility condition
$button->setDefaultButtonTexture("textures/ui/btn_default"); // Default state
$button->setHoverButtonTexture("textures/ui/btn_hover");     // Hover state
$button->setPressedButtonTexture("textures/ui/btn_pressed"); // Pressed state
$button->setLockedButtonTexture("textures/ui/btn_locked");   // Locked state
```

### Image

Image element with texture options.

```php
$image = Image::create("name", "textures/ui/my_texture");
$image->setNinesliceSize(4);           // 9-slice border size
$image->setTiled(true);                // Enable tiling
$image->setTiledScale([2.0, 2.0]);    // Tile scale
$image->setUv([16, 16]);              // UV offset (sprite sheet)
$image->setUvSize([16, 16]);          // UV crop size
$image->setGrayscale(true);           // Grayscale filter
$image->setKeepRatio(true);           // Maintain aspect ratio
$image->setBilinear(true);            // Bilinear filtering
$image->setFill(true);                // Fill mode
$image->setClipDirection("left");     // Clip direction
$image->setClipRatio(0.5);            // Clip ratio
$image->setTextureFileSystem("InUserPackage"); // File system
```

### Grid

Grid layout for repeated elements.

```php
$grid = Grid::create("name");
$grid->setGridDimensions([3, 3]);                   // Columns, Rows
$grid->setMaximumGridItems(9);                       // Max items
$grid->setGridItemTemplate("common.inventory_slot"); // Template element
$grid->setGridFillDirection("horizontal");           // Fill direction
$grid->setGridRescalingType("horizontal");           // Rescaling type
$grid->setPrecachedGridItemCount(9);                 // Precached count
```

### StackPanel

Layout panel that stacks children vertically or horizontally.

```php
$stack = StackPanel::create("name");
$stack->setOrientation(OrientationHelper::VERTICAL);   // or HORIZONTAL
$stack->addChild($element1);
$stack->addChild($element2);
```

### CloseButton (Utility)

Pre-built close button extending `common_dialogs.common_close_button_holder`.

```php
$close = CloseButton::create("name");
$close->setDefaultTextureButton("textures/ui/close_default");
$close->setHoverTextureButton("textures/ui/close_hover");
$close->setPressedTextureButton("textures/ui/close_pressed");
```

### PlayerRender (Utility)

Pre-built player skin viewer extending `start.skin_viewer_panel`.

```php
$player = PlayerRender::create("name");
$player->setSize(80, 120);
```

### BasicColor

Color utility with predefined colors and generators.

```php
BasicColor::white();       // [1.0, 1.0, 1.0]
BasicColor::black();       // [0.0, 0.0, 0.0]
BasicColor::red();         // [1.0, 0.0, 0.0]
BasicColor::green();       // [0.0, 1.0, 0.0]
BasicColor::blue();        // [0.0, 0.0, 1.0]
BasicColor::yellow();      // [1.0, 1.0, 0.0]
BasicColor::cyan();        // [0.0, 1.0, 1.0]
BasicColor::magenta();     // [1.0, 0.0, 1.0]

BasicColor::rgb(0.5, 0.3, 0.9);              // Custom RGB
BasicColor::randomColor();                     // Random color
BasicColor::randomPastelColor();               // Random pastel
BasicColor::randomShadeOfGray();               // Random gray
BasicColor::complementaryColor([1, 0, 0]);     // Complementary color
```

---

## RootBuild System

To create a new UI screen, implement the `RootBuild` interface:

```php
<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\elements\Label;

class MyScreen implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();
        $root->addElement(
            Label::create("title", "My Screen")
                ->setFontSize(Label::FONT_EXTRA_LARGE)
                ->setShadow()
        );
        return $root;
    }

    public function getNamespace(): string
    {
        return "my_screen";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "MY_SCREEN";
    }
}
```

Then register it in `Entry.php`:

```php
public function startingService(): void {
    $this->register(new MyScreen());
}
```

Run `php start.php` to generate all JSON files.

---

## Examples

The `tests/` directory contains complete examples demonstrating every feature:

| File | Description |
|---|---|
| [`LabelExample.php`](tests/LabelExample.php) | Font sizes, types, colors, shadows, scaling, anchoring |
| [`PanelExample.php`](tests/PanelExample.php) | Nested panels, background images, alpha, clipping |
| [`ButtonExample.php`](tests/ButtonExample.php) | Custom textures, visibility conditions, button factory |
| [`ImageExample.php`](tests/ImageExample.php) | Tiling, nineslice, UV mapping, grayscale, fill |
| [`GridExample.php`](tests/GridExample.php) | Grid dimensions, item templates, fill direction |
| [`StackPanelExample.php`](tests/StackPanelExample.php) | Vertical and horizontal layouts |
| [`FullMenuExample.php`](tests/FullMenuExample.php) | Complete game menu combining all elements |
| [`ColorExample.php`](tests/ColorExample.php) | All BasicColor functions demonstrated |

All examples implement `RootBuild` and are registered in `Entry.php` — run `php start.php` to generate them all.

---

## Full Example — Game Menu

This example from [`tests/FullMenuExample.php`](tests/FullMenuExample.php) builds a complete menu with background, title, player render, buttons, and close button:

```php
$root = Root::create();

$mainPanel = Panel::create("main_menu_panel")
    ->setSizePercentage(100, 100);

// Background
$mainPanel->addChild(
    Image::create("bg", "textures/ui/dialog_background_opaque")
        ->setSizePercentage(100, 100)
        ->setNinesliceSize(4)
        ->setLayer(-1)
);

// Close button
$mainPanel->addChild(
    CloseButton::create("close")
        ->setAnchorFrom(Element::ANCHOR_TOP_RIGHT)
        ->setAnchorTo(Element::ANCHOR_TOP_RIGHT)
        ->setOffset(-5, 5)
);

// Title
$mainPanel->addChild(
    Label::create("title", "My Menu")
        ->setFontSize(Label::FONT_EXTRA_LARGE)
        ->setFontType(Label::TYPE_MINECRAFT_TEN)
        ->setShadow()
        ->setColor(BasicColor::yellow())
        ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
        ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
        ->setOffset(0, 15)
);

// Player skin
$mainPanel->addChild(
    PlayerRender::create("player")
        ->setSize(80, 120)
        ->setAnchorFrom(Element::ANCHOR_LEFT_MIDDLE)
        ->setAnchorTo(Element::ANCHOR_LEFT_MIDDLE)
        ->setOffset(20, 0)
);

// Buttons
$buttonStack = StackPanel::create("buttons")
    ->setOrientation(OrientationHelper::VERTICAL)
    ->setSize(200, 160)
    ->setAnchorFrom(Element::ANCHOR_CENTER)
    ->setAnchorTo(Element::ANCHOR_CENTER);
$buttonStack->enableFactoryButton($root);

$buttonStack->addChild(
    Button::create("play", $root)
        ->setButtonText("Play")
        ->setVisibleIfTitle("Play")
        ->setSize(200, 30)
);

$mainPanel->addChild($buttonStack);
$root->addElement($mainPanel);
```

---

## OrientationHelper

Constants for StackPanel orientation:

```php
use refaltor\ui\helpers\OrientationHelper;

OrientationHelper::VERTICAL;   // "vertical"
OrientationHelper::HORIZONTAL; // "horizontal"
```

---

## Running

```bash
php start.php
```

Generated files are output to `resources/pack_example/`:
- `ui/_ui_defs.json` — UI definitions registry
- `ui/server_form.json` — Server form configuration
- `ui/custom_ui/<namespace>.json` — Individual UI screen files

---

## Wiki

For more details: https://github.com/GoldRush-developpement/EasyUIBuilder/wiki
