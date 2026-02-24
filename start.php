<?php


include __DIR__ . '/vendor/autoload.php';

ini_set('memory_limit', '-1');

spl_autoload_register(function (string $classname): void {
    if (str_contains($classname, "refaltor\\")) {
        $srcPath = "./src/" . str_replace("\\", "/", $classname) . ".php";
        if (file_exists($srcPath)) {
            require_once($srcPath);
            return;
        }
        // Fallback: load from tests/ directory
        $shortName = substr($classname, strrpos($classname, "\\") + 1);
        $testPath = "./tests/" . $shortName . ".php";
        if (file_exists($testPath)) {
            require_once($testPath);
        }
    }
});

(new \refaltor\ui\Entry())->startingService();