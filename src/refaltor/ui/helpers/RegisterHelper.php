<?php

namespace refaltor\ui\helpers;

use refaltor\ui\builders\RootBuild;

class RegisterHelper
{
    public function register(RootBuild $rootBuild): void {
        $namespace = $rootBuild->getNamespace();
        $root = $rootBuild->root();
        $root->setNamespace($namespace);
        $root->setTitleCondition($rootBuild->titleCondition());


        $uiDefsFile = $this->buildUiDefsFile($rootBuild);


        $serverFormFile = $this->buildServerFormFile($rootBuild);


        $packNamePath = $rootBuild->getPathName();
        $this->saveJsonToFile($packNamePath . "ui/_ui_defs.json", $uiDefsFile);
        $this->saveJsonToFile($packNamePath . "ui/server_form.json", $serverFormFile);


        $customUiFile = json_decode(json_encode($root), true);
        @mkdir($packNamePath . "/ui/custom_ui/");
        $this->saveJsonToFile($packNamePath . "/ui/custom_ui/" . $namespace . ".json", $customUiFile);
    }

    private function buildUiDefsFile(RootBuild $rootBuild): array {
        $namespace = $rootBuild->getNamespace();
        $uiDefs = ["ui/custom_ui/" . $namespace . ".json"];

        return ["ui_defs" => $uiDefs];
    }

    private function buildServerFormFile(RootBuild $rootBuild): array {
        $namespace = $rootBuild->getNamespace();
        $titleCondition = $rootBuild->titleCondition();

        $controls = [
            'long_form@common_dialogs.main_panel_no_buttons' => [
                '$title_panel' => 'common_dialogs.standard_title_label',
                '$title_size' => [ '100% - 14px', 10 ],
                '$size' => ['fill', 'fill'],
                '$text_name' => '#title_text',
                '$title_text_binding_type' => 'none',
                'child_control' => 'server_form.long_form_panel',
                'layer' => 2,
                'bindings' => [
                    [
                        'binding_type' => 'global',
                        'binding_condition' => 'none',
                        'binding_name' => '#title_text',
                        'binding_name_override' => '#title_text',
                    ],
                    [
                        'source_property_name' => "(not(#title_text = '$titleCondition'))",
                        'binding_type' => 'view',
                        'target_property_name' => '#visible',
                    ],
                ],
            ],
        ];

        $controls[$titleCondition . "@" . $namespace . "." . $namespace] = [
            "bindings" => [
                [
                    "binding_type" => "global",
                    "binding_condition" => "none",
                    "binding_name" => '#title_text',
                    "binding_name_override" => '#title_text',
                ],
                [
                    "source_property_name" => "(#title_text = '$titleCondition')",
                    "binding_type" => 'view',
                    "target_property_name" => '#visible',
                ],
            ],
        ];

        return [
            "namespace" => "server_form",
            'long_form@long_form' => [
                'controls' => $controls,
            ],
        ];
    }

    private function saveJsonToFile(string $filename, array $data): void {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($filename, $json);
    }
}
