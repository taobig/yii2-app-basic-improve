<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;


/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = '创建新雇员';
$this->params['breadcrumbs'][] = ['label' => '雇员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-create">
    <h1><?= Html::encode($this->title) ?></h1>


    <div class="employee-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'account')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'password')->passwordInput(['maxlength' => true]) ?>

        <?= $form->field($model, 'active')->textInput() ?>

        <?= $form->field($model, 'dt_created')->textInput() ?>

        <?= $form->field($model, 'dt_updated')->textInput() ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
