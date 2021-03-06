<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Employee */

$this->title = 'Update Employee: ' . $model->account;
$this->params['breadcrumbs'][] = ['label' => '雇员管理', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->account, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="employee-update">

    <div class="employee-form">

        <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'account')->textInput(['maxlength' => true, 'readonly' => true]) ?>

        <?= $form->field($model, 'nickname')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
            <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
        </div>

        <?php ActiveForm::end(); ?>

    </div>

</div>
