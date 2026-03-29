![logo](img/logo.png)

# EasyUIBuilder v2.1.0

![PHP 8.0+](https://img.shields.io/badge/PHP-8.0%2B-777BB4?logo=php&logoColor=white)
![Version](https://img.shields.io/badge/version-2.1.0-blue)
![License](https://img.shields.io/badge/license-MIT-green)

A PHP library for generating **Minecraft Bedrock Edition JSON UI** files using a fluent builder pattern. Build complex UI screens with clean, readable code — and output Minecraft-compatible resource packs automatically.

---

## Features

- **Fluent API** — chainable methods for all UI elements
- **Auto-generation** of `_ui_defs.json` and `server_form.json`
- **All Bedrock UI types** — Label, Panel, Button, Image, Grid, StackPanel, Toggle, Slider, EditBox, ScrollView, Dropdown, InputPanel, Screen, CustomRender
- **Binding system** — global, view, collection and visibility bindings
- **Animation system** — alpha, offset, size, color, clip, flip_book with 30+ easings
- **Variable system** — conditional variables for platform/input-specific layouts
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

## UI Elements

### Core Elements

| Element | Description |
|---------|-------------|
| **Label** | Text with font size/type/scale, shadow, color |
| **Panel** | Container with visibility, alpha, clipping, scissor |
| **Button** | Interactive button with 4-state textures, factory system |
| **Image** | Texture with UV, 9-slice, tiling, clip, grayscale |
| **Grid** | Dynamic grid layout with templates and fill direction |
| **StackPanel** | Auto-layout container (vertical/horizontal) |

### Extended Elements (v2.1)

| Element | Description |
|---------|-------------|
| **Toggle** | Checkbox/switch with radio groups, checked/unchecked controls |
| **Slider** | Value cursor with steps, direction, box/track controls |
| **EditBox** | Text input with placeholder, max length, text types |
| **ScrollView** | Scrollable container (vertical/horizontal) |
| **Dropdown** | Dropdown menu with items |
| **InputPanel** | Input handling with focus navigation, button mappings, modal |
| **Screen** | Screen root element with render flags, input absorption |
| **CustomRender** | Native renderers (paper_doll, inventory_item, panorama...) |

### Utility Elements

| Element | Description |
|---------|-------------|
| **CloseButton** | Pre-built close button extending Bedrock's common dialog |
| **PlayerRender** | Pre-built player skin viewer |

### Component Systems (v2.1)

| Component | Description |
|-----------|-------------|
| **Binding** | Data bindings (global, view, collection, visibility) |
| **Animation** | UI animations with 30+ easings and chaining |
| **Variable** | Conditional variables for adaptive layouts |

---

## RootBuild System

To create a new UI screen, implement the `RootBuild` interface:

```php
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

    public function getNamespace(): string { return "my_screen"; }
    public function getPathName(): string { return "./resources/pack_example/"; }
    public function titleCondition(): string { return "MY_SCREEN"; }
}
```

Register it in `Entry.php` and run `php start.php` to generate all JSON files.

---

## Examples

The `tests/` directory contains complete examples for every feature:

| File | Description |
|------|-------------|
| [`LabelExample.php`](tests/LabelExample.php) | Font sizes, types, colors, shadows, scaling |
| [`PanelExample.php`](tests/PanelExample.php) | Nested panels, background images, alpha, clipping |
| [`ButtonExample.php`](tests/ButtonExample.php) | Custom textures, visibility conditions, factory |
| [`ImageExample.php`](tests/ImageExample.php) | Tiling, nineslice, UV mapping, grayscale, fill |
| [`GridExample.php`](tests/GridExample.php) | Grid dimensions, item templates, fill direction |
| [`StackPanelExample.php`](tests/StackPanelExample.php) | Vertical and horizontal layouts |
| [`FullMenuExample.php`](tests/FullMenuExample.php) | Complete game menu combining all elements |
| [`ColorExample.php`](tests/ColorExample.php) | All BasicColor functions |
| [`ToggleExample.php`](tests/ToggleExample.php) | Toggle, radio groups, checked/unchecked controls |
| [`SliderExample.php`](tests/SliderExample.php) | Horizontal/vertical sliders, steps, controls |
| [`EditBoxExample.php`](tests/EditBoxExample.php) | Text/number input, placeholder, locked fields |
| [`ScrollViewExample.php`](tests/ScrollViewExample.php) | Vertical/horizontal scroll, chat jump-to-bottom |
| [`DropdownExample.php`](tests/DropdownExample.php) | Gamemode, difficulty, language dropdowns |
| [`InputPanelExample.php`](tests/InputPanelExample.php) | Modal dialog, focus nav, gesture tracking |
| [`ScreenExample.php`](tests/ScreenExample.php) | Modal/HUD/cached screens, close on hurt |
| [`CustomRenderExample.php`](tests/CustomRenderExample.php) | Paper doll, item renderer, gradient, vignette |
| [`BindingExample.php`](tests/BindingExample.php) | Global, view, collection bindings, visibility |
| [`AnimationExample.php`](tests/AnimationExample.php) | Fade, slide, pulse, bounce, elastic, chain, clip |
| [`VariableExample.php`](tests/VariableExample.php) | Platform, input-mode, screen-size conditionals |

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

For full API documentation: **https://github.com/Refaltor77/EasyUIBuilder/wiki**
