<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\components\Binding;
use refaltor\ui\components\Modification;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\Element;

/**
 * ModificationExample - Demonstrates the Modification system.
 *
 * Shows: insert_back, insert_front, insert_after, insert_before,
 *        remove, replace, swap, move operations, and vanilla element modifications.
 */
class ModificationExample implements RootBuild
{
    public function root(): Root
    {
        $root = Root::create();

        // --- Element-level modifications ---

        // A panel that modifies its controls array
        $panel = Panel::create("modified_panel")
            ->setSizePercentage(100, 100)
            ->addModification(
                Modification::insertBack(Modification::ARRAY_CONTROLS)
                    ->setValue([
                        ["injected_label@common.empty_panel" => []]
                    ])
            )
            ->addModification(
                Modification::insertFront(Modification::ARRAY_CONTROLS)
                    ->setValue([
                        ["priority_label@common.empty_panel" => []]
                    ])
            );

        // A panel demonstrating binding modifications
        $bindingPanel = Panel::create("binding_modified_panel")
            ->setSize(200, 100)
            ->setAnchorFrom(Element::ANCHOR_CENTER)
            ->setAnchorTo(Element::ANCHOR_CENTER)
            ->addBinding(Binding::global("#title_text"))
            ->addModification(
                Modification::insertBack(Modification::ARRAY_BINDINGS)
                    ->setValue([
                        [
                            "binding_type" => "view",
                            "source_property_name" => "(not (#title_text = ''))",
                            "target_property_name" => "#visible",
                        ]
                    ])
            );

        // A panel demonstrating remove modification
        $removePanel = Panel::create("cleanup_panel")
            ->setSize(100, 100)
            ->addModification(
                Modification::remove(Modification::ARRAY_BINDINGS, [
                    "binding_name" => "#obsolete_binding"
                ])
            );

        // A panel demonstrating replace modification
        $replacePanel = Panel::create("replace_panel")
            ->setSize(100, 100)
            ->addModification(
                Modification::replace(Modification::ARRAY_BINDINGS, [
                    "binding_name" => "#old_binding"
                ])->setValue([
                    "binding_name" => "#new_binding",
                    "binding_type" => "global",
                ])
            );

        // A panel demonstrating swap modification
        $swapPanel = Panel::create("swap_panel")
            ->setSize(100, 100)
            ->addModification(
                Modification::swap(
                    Modification::ARRAY_BINDINGS,
                    ["binding_name" => "#binding_a"],
                    ["binding_name" => "#binding_b"]
                )
            );

        // A panel demonstrating insert_after with control_name
        $insertAfterPanel = Panel::create("ordered_panel")
            ->setSize(200, 200)
            ->addModification(
                Modification::insertAfter("existing_control")
                    ->setValue([
                        ["new_control@common.empty_panel" => []]
                    ])
            );

        // A panel demonstrating move operations
        $movePanel = Panel::create("reorder_panel")
            ->setSize(200, 200)
            ->addModification(
                Modification::moveFrontWhere(
                    Modification::ARRAY_BINDINGS,
                    ["binding_name" => "#important_binding"]
                )
            );

        $panel->addChilds([$bindingPanel, $removePanel, $replacePanel, $swapPanel, $insertAfterPanel, $movePanel]);
        $root->addElement($panel);

        // --- Vanilla element modifications (path syntax) ---

        // Modify the HUD title text to hide when text equals a specific value
        $root->modifyVanillaElement("hud_title_text/title_frame/title", [
            Modification::insertBack(Modification::ARRAY_BINDINGS)
                ->setValue([
                    [
                        "binding_type" => "view",
                        "source_property_name" => "(not (#text = 'hidden_title'))",
                        "target_property_name" => "#visible",
                    ]
                ]),
        ]);

        // Add a custom control to the HUD
        $root->modifyVanillaElement("hud_screen", [
            Modification::insertBack(Modification::ARRAY_CONTROLS)
                ->setValue([
                    ["custom_hud_element@" . $root->namespace . ".modified_panel" => []]
                ]),
        ]);

        // Remove a binding from a vanilla element
        $root->modifyVanillaElement("start_screen/play_button", [
            Modification::remove(Modification::ARRAY_BINDINGS, [
                "binding_name" => "#some_vanilla_binding"
            ]),
        ]);

        return $root;
    }

    public function getNamespace(): string
    {
        return "modification_example";
    }

    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    public function titleCondition(): string
    {
        return "MODIFICATION_EXAMPLE";
    }
}
