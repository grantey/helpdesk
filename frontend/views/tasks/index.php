<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\jui\DatePicker;
use yii\helpers\StringHelper;
use yii\bootstrap\Modal;


/* @var $this yii\web\View */
/* @var $searchModel common\models\TasksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои задачи';

?>
<div class="tasks-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <div>
        <?= Html::button('Новая задача', ['data-target' => 'create', 'data-title' => 'Новая задача', 'class' => 'btn btn-success modal-btn']) ?>
    </div>    
    
    <?php yii\widgets\Pjax::begin(['id' => 'tasks-list']); ?>
    
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'layout' => '{summary}{items}{pager}',
        'rowOptions' => function ($model, $key, $index, $grid)
        {
            if($model->statusId === 4 ) {
                return ['style' => 'background-color:#f2dede;'];
            }
            elseif ($model->statusId === 3) {
                return ['style' => 'background-color:#dff0d8;'];
            }
        },
        'columns' => [
            [
                'attribute' => 'companyLabel',
                'format' => 'raw',
                'filter' => $companyList,
                'contentOptions' => ['style' => 'width: 140px;']
            ],
            [
                'attribute' => 'author',
                'contentOptions' => ['style' => 'width: 150px;']
            ],
            [
                'attribute' => 'message',
                'value' => function($model) {
                    return StringHelper::truncate($model->message, 100);
                },
            ],            
            [
                'attribute' => 'date_get',
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_get',
                    'options' => [
                        'class' => 'form-control'
                    ],
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
                'contentOptions' => ['style' => 'width: 150px;']
            ],
            [
                'attribute' => 'date_finish',
                'format' => 'raw',
                'filter' => DatePicker::widget([
                    'model' => $searchModel,
                    'attribute' => 'date_finish',
                    'options' => [
                        'class' => 'form-control'
                    ],
                    'dateFormat' => 'yyyy-MM-dd',
                ]),
                'value' => function($model) {
                    return $model->date_finish !== NULL ? $model->date_finish : 'нет';
                },
                'contentOptions' => ['style' => 'width: 150px;']
            ],
            [
                'attribute' => 'statusLabel',
                'format' => 'raw',
                'filter' => $statusList,
                'contentOptions' => ['style' => 'width: 140px;']
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($url,$model) {
                        return Html::button('Просмотр', ['data-target' => 'view?id='.$model->id, 'data-title' => 'Задача №'.$model->id, 'class' => 'btn modal-btn']);
                    },
                    'update' => function ($url,$model) {
                        return Html::button('Изменить', ['data-target' => 'update?id='.$model->id, 'data-title' => 'Изменить задачу №'.$model->id, 'class' => 'btn btn-info modal-btn']);
                    },
                ],
            ],
        ],
    ]); ?>
    
    <?php yii\widgets\Pjax::end(); ?>
    
    <?php
        Modal::begin([
            'header' => '',
            'id' => 'modal',
            'size' => 'modal-lg',       
        ]);
        
        echo "<div id='modal-content'></div>";
        
        Modal::end(); 
    ?>    
    
</div>
