<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '雇员管理';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="employee-index">

    <?php Pjax::begin(); ?>

    <p>
        <?= Html::a('创建新雇员', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $model,
        'columns' => [
//            ['class' => 'yii\grid\SerialColumn'],
            'id',
            'account',
            'nickname',
//            'password',
//            'active',
            //'dt_created',
            //'dt_updated',

            [
                'class' => yii\grid\ActionColumn::class,
                'template' => '{view} <span style="margin-left:20px;"></span>{update} ',
            ],
        ],
    ]); ?>
    <?php Pjax::end(); ?>
</div>
