<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\forms\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = '修改密码';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1></h1>

    <?php $form = ActiveForm::begin([
        'id' => 'login-form',
        'layout' => 'horizontal',
        'fieldConfig' => [
            'template' => "{label}\n<div class=\"col-lg-3\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
            'labelOptions' => ['class' => 'col-lg-1 control-label'],
        ],
    ]); ?>

    <div class="form-group field-loginform-username required">
        <label class="col-lg-1 control-label" for="loginform-username">Username</label>
        <div class="col-lg-3">
            <input type="text" id="loginform-username" class="form-control" value="<?=$username?>" disabled="disabled">
        </div>
        <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
    </div>

    <?php //echo $form->field($model, 'username')->textInput(['autofocus' => true, 'value' => $model->username]) ?>

    <?php //echo $form->field($model, 'password')->passwordInput() ?>
    <div class="form-group field-loginform-password-old required">
        <label class="col-lg-1 control-label" for="loginform-password-old">当前密码</label>
        <div class="col-lg-3">
            <input type="password" id="loginform-password-old" name="old_password" class="form-control" autofocus />
        </div>
        <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
    </div>

    <div class="form-group field-loginform-password required">
        <label class="col-lg-1 control-label" for="loginform-password">新密码</label>
        <div class="col-lg-3">
            <input type="password" id="loginform-password" name="new_password" class="form-control" />
        </div>
        <div class="col-lg-8"><div class="help-block help-block-error "></div></div>
    </div>

    <div class="form-group">
        <div class="col-lg-offset-1 col-lg-11">
            <?= Html::submitButton('更改密码', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
