<?php

namespace refaltor\roots;

use refaltor\ui\builders\Root;
use refaltor\ui\builders\RootBuild;
use refaltor\ui\elements\Label;

class LabelTest implements RootBuild
{

    public function root(): Root
    {
        # create root instance
        $root = Root::create();


        # create my element
        $label = Label::create("label_test", "Hello EasyUIBuilder !");
        $label->setFontSize(Label::FONT_EXTRA_LARGE);
        $label->setShadow();

        # add element in root instance
        $root->addElement($label);

        # return root instance
        return $root;
    }

    # namespace and .json file name
    public function getNamespace(): string
    {
        return "ui_test";
    }


    # put the getPathName in your texture pack
    # for the script to automatically generate the ui and
    # the condition for the visible UI
    # ---
    # example put in your developpement_resources_pack in .com_mojang :)
    public function getPathName(): string
    {
        return "./resources/pack_example/";
    }

    # title condition is very important because
    # this is the title that makes your ui will become visible
    public function titleCondition(): string
    {
        return "LABEL_TEST";
    }
}