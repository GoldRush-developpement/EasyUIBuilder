<?php

namespace refaltor\ui;


use refaltor\roots\LabelTest;
use refaltor\roots\Test;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\helpers\RegisterHelper;

class Entry extends RegisterHelper
{
    public function startingService(): void {
        $this->register(new Test());
    }
}