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
<div class="socio-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Nuevo Socio', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
<?php Pjax::begin(['id'=>'pjax-socios']); ?>    <?= GridView::widget([
		'summary' => 'Mostrando {begin}-{end} de {totalCount}',
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            'codigo',
        	'nombre',
            'apellido',
        	'telefono_emergencia',
        	['attribute'=>'Próximo vencimiento',
        		'format' => ['text'],
        		'value' => function ($model) {
        		return $model->fecha_inscripcion;
        		if(isset($model->date_end)){
        			$timezone = Yii::$app->session["client_timezone"];
        			$endDate = new \DateTime($model->date_end);
        			if($timezone>0){
        				$endDate->sub(new \DateInterval("PT{$timezone}H"));
        			}
        			else{
        				$timezone *=-1;
        				$endDate->add(new \DateInterval("PT{$timezone}H"));
        			}
        			 
        		
        			return Yii::$app->formatter->asDatetime($endDate->format('Y-m-d H:i:s'),"medium");
        		}
        		else
        			return "-";
        	}],
        	['attribute'=>'Último Pago',
        	'format' => ['text'],
        	'value' => function ($model) {
        		return $model->fecha_ultimo_pago;
        	}],
            ['class' => 'yii\grid\ActionColumn', 'template' => '{view} {pay} {update}',
            		
            		'buttons'=>
            		['view'=>function ($model, $key, $index) {
            			return '<a href="javascript:openModal('.$key->id.')" title="View" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a>';
            		
            		},
            		'pay'=>function ($model, $key, $index) {
            		return '<a href="javascript:openPayModal('.$key->id.')" title="View" aria-label="View" data-pjax="0"><span class="glyphicon glyphicon-usd"></span></a>';
            		
            		}
            		]
            ],
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
<div id="modal-place-holder">
	
</div>
<?php 
$this->registerJs("
		
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
		
		function makePayment(id,monto)
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
		
		", View::POS_END);
?>

