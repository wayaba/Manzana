<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
use yii\web\View;
use yii\helpers\Url;
use common\models\Pago;

/* @var $this yii\web\View */
/* @var $searchModel common\models\SocioSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Socios';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="box">
<div class="box-header">

    <h3 class="box-title"><?= Html::encode($this->title) ?></h3>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
	<div class="box-tools">
    <p>
        <?= Html::a('Nuevo Socio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	</div>
</div>
<?php Pjax::begin(['id'=>'pjax-socios']); ?>

<div class="box-body table-responsive no-padding" >    
<?= GridView::widget([
		//'summary' => 'Mostrando {begin}-{end} de {totalCount}',
		'summary' => false,
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
		'tableOptions'=>['class'=> 'table table-hover'],
        'columns' => [
            'codigo',
        	'nombre',
            'apellido',
        	'telefono_emergencia',
        	['attribute'=>'Plan',
        	'format' => ['text'],
        	'value' => function ($model) {
        		return $model->plan->nombre;
        	}],
        		['attribute'=>'Próximo vencimiento',
        		'format' => ['raw'],
        		'value' => function ($model) {
        		$fecha_proximo_vencimiento = \DateTime::createFromFormat ( 'd/m/Y' , $model->fecha_proximo_vencimiento );
        		if($fecha_proximo_vencimiento)
        		{
        			$today = new \DateTime();
        			if($fecha_proximo_vencimiento>$today)
        			{
        				return '<span class="label label-success">'.$model->fecha_proximo_vencimiento.'</span>&nbsp;&nbsp;  <a href="javascript:openChangeDueDateModal('.$model->id.')" data-toggle="tooltip" aria-label="View" data-placement="top" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>';
        			}
        			else
        			{
        				return '<span class="label label-danger">'.$model->fecha_proximo_vencimiento.'</span>&nbsp;&nbsp;  <a href="javascript:openChangeDueDateModal('.$model->id.')" data-toggle="tooltip" aria-label="View" data-placement="top" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>';
        			}
        		}
        		return $model->fecha_proximo_vencimiento;
        		        		
        	}],
        	['attribute'=>'Último Pago',
        	'format' => ['text'],
        	'value' => function ($model) {
        		return $model->fecha_ultimo_pago;
        	}],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {pay} {update}',
            		
            		'buttons'=>
            		['view'=>function ($model, $key, $index) {
            			//return '<a href="javascript:openModal('.$key->id.')" title="Ver" data-toggle="tooltip" aria-label="View" data-placement="top" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>';
            			return '<a href="javascript:openModal('.$key->id.')" data-toggle="tooltip" aria-label="View" data-placement="top" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>';
            		
            		},
            		'pay'=>function ($model, $key, $index) {
            		//return '<a href="javascript:openPayModal('.$key->id.')" title="Cargar pago" data-toggle="tooltip"  aria-label="View" data-placement="top" data-pjax="0"><span class="glyphicon glyphicon-usd"></span></a>';
            		return '<a href="javascript:openPayModal('.$key->id.')"  data-toggle="tooltip"  aria-label="View" data-placement="top" data-pjax="0"><span class="glyphicon glyphicon-usd"></span></a>';
            		
            		},
            		'update'=>function ($model, $key, $index) {
            		//return '<a href="/index.php?r=socio%2Fupdate&amp;id='.$key->id.'" title="Actualizar"  data-toggle="tooltip"  data-placement="top" aria-label="Actualizar" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>';
            		return '<a href="/index.php?r=socio%2Fupdate&amp;id='.$key->id.'" data-toggle="tooltip"  data-placement="top" aria-label="Actualizar" data-pjax="0"><span class="glyphicon glyphicon-pencil"></span></a>';
            		
            		}
            		
            		
            		
            		]
            ],
        ],
    ]); ?>
    </div>
<?php Pjax::end(); ?>
</div>
<div id="modal-place-holder">
	
</div>
<?php 
$this->registerJs("
	function openChangeDueDateModal(id)
	{
			$.post('". Url::to( ['socio/show-due-date-modal'] ) ."',{id:id}
				).success(function(data)
				{
					$('#modal-place-holder').html(data);
					$('#view-modal').modal('show');
				}
				).error(function(data){	
				});			
	}
		function openModal(id)
		{
			$.post('". Url::to( ['socio/show-modal'] ) ."',{id:id}
				).success(function(data)
				{
					$('#modal-place-holder').html(data);
					$('#view-modal').modal('show');
				}
				).error(function(data){	
				});			
		}
		function openPayModal(id)
		{
			$.post('". Url::to( ['socio/show-pay-modal'] ) ."',{id:id}
				).success(function(data)
				{
					$('#modal-place-holder').html(data);
					$('#view-modal').modal('show');
				}
				).error(function(data){	
				});			
		}
		
		function makePayment()
		{
			$('.modal-footer button').attr('disabled','disabled');
			$('.modal-footer button.pay').prepend('<i class=\"fa fa-refresh fa-spin\"></i>');
			$.post('". Url::to( ['socio/make-payment'] ) ."',$('#payment-form').serialize() 
				).success(function(data)
				{
					$.pjax.reload({container: '#pjax-socios'});
					$('#view-modal').modal('hide');
				}
				).error(function(data){	
				});			
		}
		
		function changeDueDate()
		{
			$('.modal-footer button').attr('disabled','disabled');
			$('.modal-footer button.change-due-date').prepend('<i class=\"fa fa-refresh fa-spin\"></i>');
			$.post('". Url::to( ['socio/change-due-date'] ) ."',$('#change-due-date-form').serialize() 
				).success(function(data)
				{
					$.pjax.reload({container: '#pjax-socios'});
					$('#view-modal').modal('hide');
				}
				).error(function(data){	
				});			
		}
		
		", View::POS_END);
?>

