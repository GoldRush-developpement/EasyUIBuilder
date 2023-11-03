<?php

namespace refaltor\ui;

use refaltor\ui\builders\Root;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Label;

class Entry
{
    public function startingService(): void {
        $this->test();
    }

    public function test(): void
    {
        $root = Root::create("common_test");


        $label = Label::create("test_label", "Hello EasyUIBuilder !");
        $label->setColor(BasicColor::magenta());
        $label->setFontSize(Label::FONT_EXTRA_LARGE);
        $label->setFontType(Label::TYPE_MINECRAFT_TEN);


        $root->addElement($label);



        $root->generateAndSaveJson("path_to_ui_file.json");
    }
}