<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Vencimiento */

$this->title = 'Update Vencimiento: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Vencimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="vencimiento-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
