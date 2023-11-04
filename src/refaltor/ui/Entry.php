<?php

namespace refaltor\ui;

use refaltor\ui\builders\Root;
use refaltor\ui\colors\BasicColor;
use refaltor\ui\elements\Button;
use refaltor\ui\elements\Element;
use refaltor\ui\elements\Image;
use refaltor\ui\elements\Label;
use refaltor\ui\elements\Panel;
use refaltor\ui\elements\StackPanel;
use refaltor\ui\elements\utils\CloseButton;
use refaltor\ui\elements\utils\StackPanelButton;
use refaltor\ui\helpers\OrientationHelper;

class Entry
{
    public function startingService(): void {
        $this->test();
    }

    public function test(): void
    {
        $root = Root::create("monture");


        $panel = Panel::create("monture_panel");
        $panel->setSize(1080, 720);

        $panel->addChild(Image::create("background", "textures/ui/bg")
            ->setSizePercentage(100, 100)
            ->setAlpha(0.8)
        );
        $panel->addChild(Image::create("title", "textures/ui/title_cosmetic")
            ->setSize(200, 100)
            ->setOffset(0, -130)
            ->setLayer(2)
        );
        $panel->addChild(Image::create("desc", "textures/ui/bg")
            ->setSize(600, 60)
            ->setOffset(0, -70)
            ->setAlpha(0.4)
            ->addChild(Label::create("desc", "Découvrez notre interface de cosmétique enchantée ! §6Personnalisez§f \nvotre personnage avec une variété de §6cosmétiques§f, des capes aux chapeaux. Exprimez votre style avec\ndes §dteintures§f et des §5stickers§f. Transformez-vous avec des §cEffets Magiques§f,\najoutez des §2Accessoires§f et enregistrez vos tenues préférées. Laissez la magie opérer\net brillez comme une étoile dans Minecraft !")
                ->setSize(580, 38)
                ->setOffset(0, 3)
                ->setAnchorTo(Element::ANCHOR_TOP_MIDDLE)
                ->setAnchorFrom(Element::ANCHOR_TOP_MIDDLE)
            )
        );









        $mainPanel = Panel::create("main_panel_button");
        $mainPanel->setSizePercentage(100, 100);
        $mainPanel->enableFactoryButton($root);

        $mainPanel->addChild(Button::create("monture_copper", $root)
            ->setCustomSize([75, 75])
            ->setOffset(0, 100)
            ->setDefaultButtonTexture("textures/ui/bg")
            ->setHoverButtonTexture("textures/ui/button_hover")
            ->setPressedButtonTexture("textures/ui/bg")
            ->setLockedButtonTexture("textures/ui/bg")
            ->setButtonText("#form_button_text")
            ->setVisibleIfTitle("TEST")
            ->addChild(Label::create("test2", "ghjhkn_text")->setLayer(5))
        );

        $mainPanel->addChild(Button::create("monture_emerald", $root)
            ->setCustomSize([75, 75])
            ->setDefaultButtonTexture("textures/ui/bg")
            ->setHoverButtonTexture("textures/ui/button_hover")
            ->setPressedButtonTexture("textures/ui/bg")
            ->setLockedButtonTexture("textures/ui/bg")
            ->setVisibleIfTitle("TEST2")
            ->addChild(Label::create("test", "ADADADADAD")->setLayer(5))
        );


        //$panel->addChild($mainPanel);

        $root->addElement($panel);

        $root->generateAndSaveJson("C:/Users/elysi/AppData/Local/Packages/Microsoft.MinecraftUWP_8wekyb3d8bbwe/LocalState/games/com.mojang/development_resource_packs/test_ui_pack/ui/monture.json");
    }
}