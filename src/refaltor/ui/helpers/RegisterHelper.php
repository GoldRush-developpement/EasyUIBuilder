<?php

namespace refaltor\ui\helpers;

use refaltor\ui\builders\RootBuild;
use refaltor\ui\validators\JsonValidator;
use refaltor\ui\validators\ValidationResult;

class RegisterHelper
{
    private bool $validationEnabled = true;
    private bool $strictValidation = false;
    private int $totalErrors = 0;
    private int $totalWarnings = 0;

    public function setValidationEnabled(bool $enabled): self
    {
        $this->validationEnabled = $enabled;
        return $this;
    }

    public function setStrictValidation(bool $strict): self
    {
        $this->strictValidation = $strict;
        return $this;
    }

    public function getTotalErrors(): int
    {
        return $this->totalErrors;
    }

    public function getTotalWarnings(): int
    {
        return $this->totalWarnings;
    }

    public function register(RootBuild $rootBuild): void {
        $namespace = $rootBuild->getNamespace();
        $root = $rootBuild->root();
        $root->setNamespace($namespace);
        $root->setTitleCondition($rootBuild->titleCondition());

        $cheminNomPaquet = $rootBuild->getPathName();
        $this->sendLog("\033[01;32m===== Building {$namespace} =====\033[0m".PHP_EOL);
        if (!is_dir($cheminNomPaquet)) {
            mkdir($cheminNomPaquet);
            mkdir($cheminNomPaquet."ui/");
            $this->sendLog("Resource pack ". $cheminNomPaquet . " not found, creating...", "info");
        }

        $fichierUiDefs = $this->buildUiDefsFile($rootBuild);
        $fichierFormulaireServeur = $this->buildServerFormFile($rootBuild);

        // Validate _ui_defs.json file
        if ($this->validationEnabled) {
            $this->runValidationUiDefs($fichierUiDefs, $namespace);
        }

        $this->saveJsonToFile($cheminNomPaquet . "ui/_ui_defs.json", $fichierUiDefs);
        $this->sendLog("File ". $cheminNomPaquet . "ui/_ui_defs.json" . " ready", "info");
        $this->saveJsonToFile($cheminNomPaquet . "ui/server_form.json", $fichierFormulaireServeur);
        $this->sendLog("File ". $cheminNomPaquet . "ui/server_form.json" . " ready", "info");

        $fichierUiPersonnalise = json_decode(json_encode($root), true);

        // Validate main UI file
        if ($this->validationEnabled) {
            $this->runValidation($fichierUiPersonnalise, $namespace);
        }

        @mkdir($cheminNomPaquet . "ui/custom_ui/");
        $this->saveJsonToFile($cheminNomPaquet . "ui/custom_ui/" . $namespace . ".json", $fichierUiPersonnalise);
        $this->sendLog("File ". $cheminNomPaquet . "ui/custom_ui/" . $namespace . ".json" ." ready, resource pack built", "info");
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

            // Check if the UI file is already included
            if (!in_array($cheminFichierUi, $uiDefs)) {
                $uiDefs[] = $cheminFichierUi;
                $jsonData["ui_defs"] = $uiDefs;
            }
        }

        return $jsonData;
    }


    public function sendLog(string $text, ?string $sender = null): void
    {
        switch ($sender) {
            case "info":
                echo"\033[01;32m[INFO] {$text}\033[0m".PHP_EOL;
                break;
            case "notice":
                echo"\033[01;34m[NOTICE] {$text}\033[0m".PHP_EOL;
                break;
            case "warning":
                echo"\033[01;33m[WARNING] {$text}\033[0m".PHP_EOL;
                break;
            case "error":
                echo"\033[01;31m[ERROR] {$text}\033[0m".PHP_EOL;
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

    private function runValidation(array $jsonData, string $namespace): void
    {
        $validator = new JsonValidator($this->strictValidation);
        $result = $validator->validate($jsonData);
        $this->printValidationResult($result, $namespace);
    }

    private function runValidationUiDefs(array $jsonData, string $namespace): void
    {
        $validator = new JsonValidator($this->strictValidation);
        $result = $validator->validateUiDefs($jsonData);
        $this->printValidationResult($result, $namespace . '/_ui_defs');
    }

    private function printValidationResult(ValidationResult $result, string $context): void
    {
        $this->totalErrors += $result->getErrorCount();
        $this->totalWarnings += $result->getWarningCount();

        foreach ($result->getErrors() as $error) {
            $this->sendLog("[VALIDATION] {$error}", "error");
        }

        foreach ($result->getWarnings() as $warning) {
            $this->sendLog("[VALIDATION] {$warning}", "warning");
        }

        if ($result->isValid() && !$result->hasWarnings()) {
            $this->sendLog("[VALIDATION] {$context}: no issues found", "info");
        }
    }

    private function saveJsonToFile(string $filename, array $data): void {
        $json = json_encode($data, JSON_PRETTY_PRINT);
        file_put_contents($filename, $json);
    }
}