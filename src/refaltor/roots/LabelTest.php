<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Label;

class LabelTest implements RootBuild
{

    public function root(): Root
    {
        # create root instance
        $root = Root::create();


        # create my element
        $label = Label::create("label_test", "Hello EasyUIBuilder !")
            ->setFontType(Label::TYPE_MINECRAFT_TEN)
            ->setFontSize(Label::FONT_EXTRA_LARGE)
            ->setColor(BasicColor::blue())
            ->setShadow();


        # add element in root instance
        $root->addElement($label);

        # return root instance
        return $root;
    }

    public function getNamespace(): string
    {
        return "ui_test";
    }

    public function getPathName(): string
    {
        return "./resources/test_ui.json";
    }
}