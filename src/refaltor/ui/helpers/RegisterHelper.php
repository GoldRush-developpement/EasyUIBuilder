<?php

namespace refaltor\ui\helpers;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;

class RegisterHelper
{
    public function register(RootBuild $rootBuild): void {
        $namespace = $rootBuild->getNamespace();
        $pathToUiFile = $rootBuild->getPathName();
        $root = Root::create();
        $root->setNamespace($namespace);
        $root->generateAndSaveJson($pathToUiFile);
    }
}