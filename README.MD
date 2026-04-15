![logo](img/logo.png)

# EasyUIBuilder v2.0.0

![PHP 8.0+](https://img.shields.io/badge/PHP-8.0%2B-777BB4?logo=php&logoColor=white)
![Version](https://img.shields.io/badge/version-2.0.0-blue)
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
- **Modification system** — non-intrusive edits to vanilla UI elements (insert, remove, replace, swap, move)
- **JSON validation** — automatic schema validation of generated files against Bedrock UI rules
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

### Extended Elements

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

### Component Systems

| Component | Description |
|-----------|-------------|
| **Binding** | Data bindings (global, view, collection, visibility) |
| **Animation** | UI animations with 30+ easings and chaining |
| **Variable** | Conditional variables for adaptive layouts |
| **Modification** | Non-intrusive edits to vanilla UI (insert, remove, replace, swap, move) |

---

## Modifications System (v2.0)

The modifications system lets you edit vanilla Bedrock UI elements without replacing entire files. This improves compatibility across resource packs.

### All Operations

| Operation | Description |
|-----------|-------------|
| `insert_back` | Insert at end of array |
| `insert_front` | Insert at start of array |
| `insert_after` | Insert after a target element |
| `insert_before` | Insert before a target element |
| `move_back` | Move target to end of array |
| `move_front` | Move target to start of array |
| `move_after` | Move target after another element |
| `move_before` | Move target before another element |
| `swap` | Swap two elements |
| `replace` | Replace an element |
| `remove` | Remove an element |

### Element-Level Modifications

Add modifications directly to any element:

```php
use refaltor\ui\components\Modification;

$panel = Panel::create("my_panel")
    ->addModification(
        Modification::insertBack(Modification::ARRAY_CONTROLS)
            ->setValue([
                ["new_child@common.empty_panel" => []]
            ])
    )
    ->addModification(
        Modification::remove(Modification::ARRAY_BINDINGS, [
            "binding_name" => "#obsolete_binding"
        ])
    );
```

### Vanilla Element Modifications

Target vanilla UI elements using path syntax on the Root builder:

```php
use refaltor\ui\components\Modification;

$root = Root::create("my_namespace");

// Hide the HUD title when text matches a value
$root->modifyVanillaElement("hud_title_text/title_frame/title", [
    Modification::insertBack(Modification::ARRAY_BINDINGS)
        ->setValue([
            [
                "binding_type" => "view",
                "source_property_name" => "(not (#text = 'hidden'))",
                "target_property_name" => "#visible",
            ]
        ]),
]);

// Add a custom element to the HUD screen
$root->modifyVanillaElement("hud_screen", [
    Modification::insertBack(Modification::ARRAY_CONTROLS)
        ->setValue([
            ["my_element@my_namespace.my_panel" => []]
        ]),
]);

// Replace a binding in a vanilla element
$root->modifyVanillaElement("start_screen/play_button", [
    Modification::replace(Modification::ARRAY_BINDINGS, [
        "binding_name" => "#old_binding"
    ])->setValue([
        "binding_name" => "#new_binding",
        "binding_type" => "global",
    ]),
]);

// Swap two bindings
$root->modifyVanillaElement("inventory_screen/root_panel", [
    Modification::swap(
        Modification::ARRAY_BINDINGS,
        ["binding_name" => "#binding_a"],
        ["binding_name" => "#binding_b"]
    ),
]);
```

### Available Target Arrays

Use the constants for `array_name`:

| Constant | Value |
|----------|-------|
| `Modification::ARRAY_CONTROLS` | `controls` |
| `Modification::ARRAY_BINDINGS` | `bindings` |
| `Modification::ARRAY_VARIABLES` | `variables` |
| `Modification::ARRAY_ANIMS` | `anims` |
| `Modification::ARRAY_BUTTON_MAPPINGS` | `button_mappings` |

---

## JSON Validation (v2.0)

Generated JSON files are automatically validated against Bedrock UI rules before writing. The validator checks:

- Element types (14 valid Bedrock types)
- Property names per element type (strict mode)
- Anchor values (9-point system)
- Size/offset format and color ranges
- Binding structure (type, required fields per binding type)
- Animation types (9 types), easings (32 values), duration, from/to
- Variable structure (`requires` field, values)
- Modification operations (11 types) and required fields
- `_ui_defs.json` structure and duplicates
- Custom renderer names (20 known renderers)

### Configuration

```php
$entry = new Entry();

// Disable validation entirely
$entry->setValidationEnabled(false);

// Enable strict mode (warns about unknown properties)
$entry->setStrictValidation(true);
```

### Standalone Usage

```php
use refaltor\ui\validators\JsonValidator;

$validator = new JsonValidator(strict: true);
$result = $validator->validate($jsonData);

foreach ($result->getErrors() as $error) {
    echo "ERROR: $error\n";
}
foreach ($result->getWarnings() as $warning) {
    echo "WARNING: $warning\n";
}

echo $result->isValid() ? "Valid!" : "Invalid.";
```

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
| [`ModificationExample.php`](tests/ModificationExample.php) | All modification operations, vanilla element targeting |

---

## Running

```bash
php start.php
```

Generated files are output to `resources/pack_example/`:
- `ui/_ui_defs.json` — UI definitions registry
- `ui/server_form.json` — Server form configuration
- `ui/custom_ui/<namespace>.json` — Individual UI screen files

Validation results are displayed during generation:

```
===== Building my_screen =====
[INFO] [VALIDATION] my_screen/_ui_defs: no issues found
[INFO] File ./resources/pack_example/ui/_ui_defs.json ready
[INFO] File ./resources/pack_example/ui/server_form.json ready
[INFO] [VALIDATION] my_screen: no issues found
[INFO] File ./resources/pack_example/ui/custom_ui/my_screen.json ready, resource pack built

[INFO] Validation complete: no issues found.
```

---

## Changelog

### v2.0.0
- **Modifications system** — 11 operations to edit vanilla UI elements non-intrusively
- **Vanilla element targeting** — path syntax (`hud_screen/hud_title_text`) via `Root::modifyVanillaElement()`
- **JSON validation** — automatic schema validation with `JsonValidator` (types, bindings, animations, modifications)
- **Strict validation mode** — detect unknown properties per element type
- **English log output** — all build/validation messages in English
- **`JSON_UNESCAPED_SLASHES`** — proper path output in generated JSON

### v1.1.0
- **JSON schema validation** — initial validation system

### v1.0.0
- Initial release with 14 element types, bindings, animations, variables

---

## Wiki

For full API documentation: **https://github.com/Refaltor77/EasyUIBuilder/wiki**
