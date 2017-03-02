<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\datetime\DateTimePicker;

/* @var $this yii\web\View */
/* @var $model common\models\Tasks */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="tasks-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col-sm-3">
            <?= $form->field($model, 'companyId')->dropDownList($companyList) ?>    
        </div>
        <div class="col-sm-9">
            <?= $form->field($model, 'author')->textInput(['maxlength' => true]) ?>
        </div>
    </div>
    
    <?= $form->field($model, 'message')->textarea(['rows' => 6]) ?>
    
    <?= $form->field($model, 'comment')->textarea(['rows' => 3]) ?>

    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'date_get')->widget(DateTimePicker::className(), [
                'model' => $model,        
                'attribute' => 'date_get',
                'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,        
                'options' => ['placeholder' => 'Выберите дату и время ...'],
                'layout' => '{picker}{input}{remove}',
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii:ss',
                    'todayHighlight' => true
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'statusId')->dropDownList($statusList) ?>
        </div>
    </div>
    
    <div class="row">
        <div class="col-sm-6">
            <?= $form->field($model, 'date_start')->widget(DateTimePicker::className(), [
                'model' => $model,
                'attribute' => 'date_start',        
                'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,        
                'options' => ['placeholder' => 'Выберите дату и время ...'],
                'layout' => '{picker}{input}{remove}',
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii:ss',
                    'todayHighlight' => true
                ],
            ]) ?>
        </div>
        <div class="col-sm-6">
            <?= $form->field($model, 'date_finish')->widget(DateTimePicker::className(), [
                'model' => $model,
                'attribute' => 'date_finish',
                'type' => DateTimePicker::TYPE_COMPONENT_PREPEND,        
                'options' => ['placeholder' => 'Выберите дату и время ...'],
                'layout' => '{picker}{input}{remove}',
                'pluginOptions' => [
                    'todayHighlight' => true,
                    'todayBtn' => true,
                    'autoclose' => true,
                    'format' => 'yyyy-mm-dd hh:ii:ss',
                    'todayHighlight' => true
                ],
            ]) ?>
        </div>
    </div>
    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Изменить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
