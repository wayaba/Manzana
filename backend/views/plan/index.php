<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel common\models\PlanSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Planes';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<div class="box-tools">
    <p>
        <?= Html::a('Nuevo Plan', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	</div>
</div>
<?php Pjax::begin(['id'=>'pjax-plans']); ?>

<div class="box-body table-responsive no-padding" >    
<?= GridView::widget([
		'summary' => false,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => 
            ['nombre',
            'valor_cuota',
            ['attribute'=>'Cantidad de Socios',
            		'format' => ['html'],
            		'value' => function ($model) {
            				return '<span class="label label-success">'.$model->getSocios()->count().' ( $ '.number_format($model->getSocios()->count()*$model->valor_cuota,2).' )</span>';
            		
            }],            		
            		
            ['class' => 'yii\grid\ActionColumn', 'template' => '{update}'],
        ],
    ]); ?>
<?php Pjax::end(); ?>
</div>
