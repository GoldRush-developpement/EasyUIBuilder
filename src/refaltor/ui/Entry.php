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
use refaltor\roots\ToggleExample;
use refaltor\roots\SliderExample;
use refaltor\roots\EditBoxExample;
use refaltor\roots\ScrollViewExample;
use refaltor\roots\DropdownExample;
use refaltor\roots\InputPanelExample;
use refaltor\roots\ScreenExample;
use refaltor\roots\CustomRenderExample;
use refaltor\roots\BindingExample;
use refaltor\roots\AnimationExample;
use refaltor\roots\VariableExample;
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
        $this->register(new ToggleExample());
        $this->register(new SliderExample());
        $this->register(new EditBoxExample());
        $this->register(new ScrollViewExample());
        $this->register(new DropdownExample());
        $this->register(new InputPanelExample());
        $this->register(new ScreenExample());
        $this->register(new CustomRenderExample());
        $this->register(new BindingExample());
        $this->register(new AnimationExample());
        $this->register(new VariableExample());
    }
}
