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

        $cheminNomPaquet = $rootBuild->getPathName();
        $this->sendLog("\033[01;32m===== Début de la création de {$namespace} =====\033[0m".PHP_EOL);
        if (!is_dir($cheminNomPaquet)) {
            mkdir($cheminNomPaquet);
            mkdir($cheminNomPaquet."ui/");
            $this->sendLog("Ressource-pack ". $cheminNomPaquet . " non trouvé, création en cours...", "info");
        }

        $fichierUiDefs = $this->buildUiDefsFile($rootBuild);
        $fichierFormulaireServeur = $this->buildServerFormFile($rootBuild);

        $this->saveJsonToFile($cheminNomPaquet . "ui/_ui_defs.json", $fichierUiDefs);
        $this->sendLog("Fichier ". $cheminNomPaquet . "ui/_ui_defs.json" . " prêt", "info");
        $this->saveJsonToFile($cheminNomPaquet . "ui/server_form.json", $fichierFormulaireServeur);
        $this->sendLog("Fichier ". $cheminNomPaquet . "ui/server_form.json" . " prêt", "info");

        $fichierUiPersonnalise = json_decode(json_encode($root), true);
        @mkdir($cheminNomPaquet . "ui/custom_ui/");
        $this->saveJsonToFile($cheminNomPaquet . "ui/custom_ui/" . $namespace . ".json", $fichierUiPersonnalise);
        $this->sendLog(" Dernier fichier ". $cheminNomPaquet . "ui/custom_ui/" . $namespace . ".json" ." prêt, ressource-pack créé", "info");
    }

    private function buildUiDefsFile(RootBuild $rootBuild): array {
        $namespace = $rootBuild->getNamespace();
        $cheminFichierUi = "ui/custom_ui/$namespace.json";

        if (!file_exists($rootBuild->getPathName() . "ui/_ui_defs.json")) {
            $jsonData = ["ui_defs" => []];
        } else {
            $jsonData = file_get_contents($rootBuild->getPathName() . "ui/_ui_defs.json");
            $jsonData = json_decode($jsonData, true);
            $uiDefs = $jsonData["ui_defs"];

            // Vérifier si le fichier UI est déjà inclus
            if (!in_array($cheminFichierUi, $uiDefs)) {
                $uiDefs[] = $cheminFichierUi;
                $jsonData["ui_defs"] = $uiDefs;
            }
        }

        return $jsonData;
    }


    public function sendLog(string $text, string $sender = null): void
    {
        switch ($sender) {
            case "info":
                echo"\033[01;32m[INFO] {$text}\033[0m".PHP_EOL;
                break;
            case "notice":
                echo"\033[01;34m[NOTICE] {$text}\033[0m".PHP_EOL;
                break;
            case "warning":
                echo"\033[01;33m[AVERTISSEMENT] {$text}\033[0m".PHP_EOL;
                break;
            case "error":
                echo"\033[01;31m[ERREUR] {$text}\033[0m".PHP_EOL;
                break;
            default:
                echo $text;
        }
    }

    private function buildServerFormFile(RootBuild $rootBuild): array {
        $namespace = $rootBuild->getNamespace();
        $titleCondition = $rootBuild->titleCondition();

        $cheminNomPaquet = $rootBuild->getPathName();
        $fichierFormulaireServeur = $cheminNomPaquet . "ui/server_form.json";
        $jsonData = [];

        if (file_exists($fichierFormulaireServeur)) {
            $contenuFormulaireServeur = file_get_contents($fichierFormulaireServeur);
            $jsonData = json_decode($contenuFormulaireServeur, true);
        }

        $controles = $jsonData["long_form@long_form"]["controls"] ?? [];
        $nouvelleCleControle = $titleCondition . "@" . $namespace . "." . $namespace;
        $nouveauControle = [
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

        $controles[$nouvelleCleControle] = $nouveauControle;

        $cleControleBase = 'long_form@common_dialogs.main_panel_no_buttons';
        if (!isset($controles[$cleControleBase])) {
            $controles[$cleControleBase] = [
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

        $jsonData["long_form@long_form"]["controls"] = $controles;

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