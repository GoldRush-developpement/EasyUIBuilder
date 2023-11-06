<?php

namespace refaltor\ui;


use refaltor\roots\LabelTest;
use refaltor\roots\Test;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\helpers\RegisterHelper;

class Entry extends RegisterHelper
{
    public function startingService(): void {



        # register root ui
        $this->register(new LabelTest());
        $this->register(new Test());
    }
}