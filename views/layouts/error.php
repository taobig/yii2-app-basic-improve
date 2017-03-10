<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

\yii\bootstrap\BootstrapAsset::register($this);
$this->title = $name;

$this->beginPage();
?>
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

<div class="container">
    <div class="site-error">

        <h1><?= Html::encode($this->title) ?></h1>

        <div class="alert alert-danger jumbotron">
            <h4 style="margin-bottom: 0"><strong><?= nl2br(Html::encode($message)) ?></strong></h4>
        </div>

        <p style="margin:20px 0 0;">
            <a href="<?= \Yii::$app->request->getHostInfo(); ?>">
                <button type="button" class="btn btn-link">返回首页</button>
            </a>
            <?php if (Yii::$app->request->getReferrer()) { ?>
                <a href="<?= Yii::$app->request->getReferrer() ?>">
                    <button type="button" class="btn btn-link">返回上一页</button>
                </a>
            <?php } ?>
        </p>

    </div>
</div>
<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
