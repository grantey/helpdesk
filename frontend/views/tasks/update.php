<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Tasks */

$this->title = 'Изменить задачу';
?>

<?= $this->render('_form', [
    'model' => $model,
    'statusList' => $statusList,
    'companyList' => $companyList
]) ?>