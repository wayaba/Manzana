<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Vencimiento */

$this->title = 'Create Vencimiento';
$this->params['breadcrumbs'][] = ['label' => 'Vencimientos', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vencimiento-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
