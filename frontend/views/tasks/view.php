<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Tasks */

$this->title = $model->id;

?>

<p>        
    <?= Html::a('Новая задача', ['create'], ['class' => 'btn btn-success']) ?>    
    <?= Html::a('Изменить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
        'class' => 'btn btn-danger',
        'data' => [
            'confirm' => 'Вы уверены, что хотите удалить эту задачу?',
            'method' => 'post',
        ],
    ]) ?>
</p>

<?= DetailView::widget([
    'model' => $model,
    'attributes' => [
        [
            'attribute' => 'companyId',                
            'value' => $model->company->label,                
        ],
        'author',
        [
            'attribute' => 'message',
            'format' => 'ntext'
        ],           
        [
            'attribute' => 'comment',
            'format' => 'ntext',
            'value' => $model->comment === NULL ? '' : $model->comment,
        ],
        'date_get',
        [
            'attribute' => 'date_start',
            'value' => $model->date_start === NULL ? 'задача не начата' : $model->date_start,
        ],            
        [
            'attribute' => 'date_finish',
            'value' => $model->date_finish === NULL ? 'задача не завершена' : $model->date_finish,
        ],
        [
            'attribute' => 'statusId',
            'value' => $model->status->label,
        ]
    ],
]) ?>