<?php

namespace humhub\modules\user\widgets;

use Yii;
use humhub\modules\user\models\User;
use humhub\modules\user\permissions\ViewAboutPage;

class ProfileMenu extends \humhub\widgets\BaseMenu
{
    /**
     * @var User
     */
    public $user;
    /**
     * @inheritdoc
     */
    public $template = "@humhub/widgets/views/leftNavigation";
    /**
     * @inheritdoc
     */
    public function init()
    {
        $this->addItemGroup([
            'id' => 'profile',
            'label' => Yii::t('UserModule.widgets_ProfileMenuWidget', '<strong>Profile</strong> menu'),
            'sortOrder' => 100,
        ]);
        $this->addItem([
            'label' => Yii::t('UserModule.widgets_ProfileMenuWidget', 'Stream'),
            'group' => 'profile',
            'icon' => '<i class="fa fa-bars"></i>',
            'url' => $this->user->createUrl('//user/profile/home'),
            'sortOrder' => 200,
            'isActive' => (Yii::$app->controller->id == "profile" && (Yii::$app->controller->action->id == "index" || Yii::$app->controller->action->id == "home")),
        ]);
        if ($this->user->permissionManager->can(new ViewAboutPage())) {
            $this->addItem([
                'label' => Yii::t('UserModule.widgets_ProfileMenuWidget', 'About'),
                'group' => 'profile',
                'icon' => '<i class="fa fa-info-circle"></i>',
                'url' => $this->user->createUrl('//user/profile/about'),
                'sortOrder' => 300,
                'isActive' => (Yii::$app->controller->id == "profile" && Yii::$app->controller->action->id == "about"),
            ]);
        }
        parent::init();
    }
    /**
     * @inheritdoc
     */
    public function run()
    {
        if (Yii::$app->user->isGuest && $this->user->visibility != User::VISIBILITY_ALL) {
            return;
        }
        return parent::run();
    }
}
?>
