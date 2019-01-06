<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\grid\DataColumn;
use app\models\Employee;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $model Employee */

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
            [
                'class' => DataColumn::class,
                'attribute' => 'account',
                'enableSorting' => false,
                'format' => 'raw',
//                'value' => function (Employee $_model, $key, $index, $column) {
//                    return Html::a($_model->account, ['employee/view', 'id' => $_model->id]);
//                }
            ],
            [
                'class' => DataColumn::class,
                'attribute' => 'nickname',
                'enableSorting' => false,
            ],
//            'password',
//            'is_deleted',
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
