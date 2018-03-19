<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model common\models\Configuracion */

$this->title = 'Create Configuracion';
$this->params['breadcrumbs'][] = ['label' => 'Configuracions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configuracion-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
