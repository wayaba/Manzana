<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Socio */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Socios', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="socio-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'nombre',
            'apellido',
            'fecha_inscripcion',
            'email:email',
            'dni',
            'tiene_apto_medico',
            'status',
            'facebook_id',
            'created_at',
            'updated_at',
        ],
    ]) ?>

</div>
