<?php

namespace refaltor\ui;


use refaltor\roots\LabelExample;
use refaltor\roots\PanelExample;
use refaltor\roots\ButtonExample;
use refaltor\roots\ImageExample;
use refaltor\roots\GridExample;
use refaltor\roots\StackPanelExample;
use refaltor\roots\FullMenuExample;
use refaltor\roots\ColorExample;
use refaltor\ui\helpers\RegisterHelper;

class Entry extends RegisterHelper
{
    public function startingService(): void {
        $this->register(new LabelExample());
        $this->register(new PanelExample());
        $this->register(new ButtonExample());
        $this->register(new ImageExample());
        $this->register(new GridExample());
        $this->register(new StackPanelExample());
        $this->register(new FullMenuExample());
        $this->register(new ColorExample());
    }
}
