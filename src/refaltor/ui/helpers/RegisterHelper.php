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
        $jsonData = file_get_contents($rootBuild->getPathName() . "/ui/_ui_defs.json");
        $namespace = $rootBuild->getNamespace();
        $uiFilePath = "ui/custom_ui/$namespace.json";

        if (!$jsonData) {
            $jsonData = ["ui_defs" => []];
        } else {
            $jsonData = json_decode($jsonData, true);
            $uiDefs = $jsonData["ui_defs"];

            // Vérifier si le fichier UI est déjà inclus
            if (!in_array($uiFilePath, $uiDefs)) {
                $uiDefs[] = $uiFilePath;
                $jsonData["ui_defs"] = $uiDefs;
            }
        }

        return $jsonData;
    }


    private function buildServerFormFile(RootBuild $rootBuild): array {
        $namespace = $rootBuild->getNamespace();
        $titleCondition = $rootBuild->titleCondition();

        $packNamePath = $rootBuild->getPathName();
        $serverFormFile = $packNamePath . "ui/server_form.json";
        $jsonData = [];

        if (file_exists($serverFormFile)) {
            $contentServerForm = file_get_contents($serverFormFile);
            $jsonData = json_decode($contentServerForm, true);
        }

        $controls = $jsonData["long_form@long_form"]["controls"] ?? [];
        $newControlKey = $titleCondition . "@" . $namespace . "." . $namespace;
        $newControl = [
            "bindings" => [
                [
                    "binding_type" => "global",
                    "binding_condition" => "none",
                    "binding_name" => "#title_text",
                    "binding_name_override" => "#title_text",
                ],
                [
                    "source_property_name" => "(#title_text = '$titleCondition')",
                    "binding_type" => "view",
                    "target_property_name" => "#visible",
                ],
            ],
        ];

        $controls[$newControlKey] = $newControl;

        $baseControlKey = 'long_form@common_dialogs.main_panel_no_buttons';
        if (!isset($controls[$baseControlKey])) {
            $controls[$baseControlKey] = [
                '$title_panel' => 'common_dialogs.standard_title_label',
                '$title_size' => ['100% - 14px', 10],
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
                        'source_property_name' => "(not(#title_text = ''))",
                        'binding_type' => 'view',
                        'target_property_name' => '#visible',
                    ],
                ],
            ];
        }

        $jsonData["long_form@long_form"]["controls"] = $controls;

        foreach ($jsonData["long_form@long_form"]["controls"] as $index => $values) {
            if (isset($values['$title_panel'])) {
                $bindinds = $values['bindings'];
                $condition = $bindinds[1]['source_property_name'];
                if (strlen($condition) >= 2) {
                    $condition = substr($condition, 0, -1);
                    $condition .= "not(#title_text = '$titleCondition'))";
                }
                $jsonData["long_form@long_form"]["controls"]["long_form@common_dialogs.main_panel_no_buttons"]["bindings"][1]["source_property_name"] = $condition;
                $jsonData["long_form@long_form"]["con"][1]["source_property_name"] = $condition;
            }
        }

        return $jsonData;
    }




    private function saveJsonToFile(string $filename, array $data): void {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($filename, $json);
    }
}
