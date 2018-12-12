<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\components\StaticResource;
use app\components\FlashMessage;

\yii\web\YiiAsset::register($this);
\yii\bootstrap\BootstrapAsset::register($this);
StaticResource::loadStyle($this, 'styles/site.css');
StaticResource::loadScript($this, 'scripts/common.js');
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => 'My Company',
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    $menuItems = [];
    if (Yii::$app->user->isGuest) {
        $menuItems = array_merge($menuItems,
            [
                ['label' => 'Login', 'url' => ['/site/login']]
            ]
        );
    } else {
        $menuItems = array_merge($menuItems,
            [
                [
                    'label' => Yii::$app->user->identity->username,
                    'items' => [
                        ['label' => '进入管理后台', 'url' => Url::to(['/admin/default/index'])],
                        ['label' => '修改密码', 'url' => Url::to(['site/password'])],
                        ['label' => '退出', 'url' => Url::to(['site/logout']), 'options' => ['class' => 'logout']],
                    ]
                ]
            ]);
    }
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
    ]);

    NavBar::end();
    ?>

    <div class="container">
        <?php if ($message = FlashMessage::getSuccess()) { ?>
            <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><?php echo $message ?></span>
            </div>
        <?php } ?>
        <?php if ($message = FlashMessage::getDanger()) { ?>
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <span><?php echo $message ?></span>
            </div>
        <?php } ?>

        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; My Company <?= date('Y') ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
