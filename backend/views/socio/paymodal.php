<?php

use yii\widgets\DetailView;
use common\models\Pago;
use yii\bootstrap\ActiveForm;
use common\models\Configuracion;
use yii\bootstrap\Html;

?>

<div class="modal fade" id="view-modal">
	          <div class="modal-dialog">
	            <div class="modal-content">
	              <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Carga de pago</h4>
	              </div>
	              <div class="modal-body">
	              	<div class="row-fluid">
	              	<div class="span12">
	              	<div class="box box-success">
	              	<div class="box-body">
	              
					<?= DetailView::widget([
				        'model' => $model,
				        'attributes' => [
				        	[ 
				        		'attribute'=>'nombre',
				        		'label' => 'Nombre y Apellido',
				        		'value' => $model->nombre .' '.$model->apellido
				        	],
				        	[
				        		'attribute' => 'estado',
				        		'value' => $model->estado?'Activo':'Inactivo',
				        	],
				        	[
				        		'attribute' => 'Último Pago',
				        		'label' => 'Último Pago',
				        		'value' => $model->fecha_ultimo_pago,
				        	],
				        ],
				    ]) ?>
				    </div>
				    </div>
				    </div>
				    </div>
				    <div class="row-fluid">
	              	<div class="span12">
	              	<div class="box box-success">
					
					<?php $form = ActiveForm::begin(['action' => ['socio/make-payment'],'id'=>'payment-form']); ?>
					<?php
					$pagoModel = new Pago();

					$configuracion = Configuracion::find()
					->orderBy('created_at','desc')
					->one();
					$pagoModel->valor_cuota = $model->plan->valor_cuota;
					$pagoModel->monto = $model->plan->valor_cuota;
					$pagoModel->socio_id = $model->id;
						
					?>
	              	<div class="box-header with-border">
	              		<h3 class="box-title"><?=$model->plan->nombre?></h3>
	              	</div>

	              	<div class="box-body">
	
				    <?= $form->field($pagoModel, 'socio_id')->hiddenInput()->label(false) ?>

					<div class="row">
						<div class="col-md-6">
					    <?= $form->field($pagoModel, 'valor_cuota')->textInput(['maxlength' => true,'readonly'=>'true']) ?>
					    </div>
						<div class="col-md-6">
					    <?= $form->field($pagoModel, 'monto')->textInput(['maxlength' => true]) ?>
					    </div>
					</div>
				    <?php ActiveForm::end(); ?>
					
				    </div>
				    </div>
				    </div>
				    </div>
	              </div>
	              <div class="modal-footer">
	              <div class="btn-group">
	                <button type="button" onclick="makePayment()" class="btn btn-success pay" > Pagar</button>
	              </div>
	              <div class="btn-group">
	                <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
	              </div>
	              </div>
	            </div>
	            <!-- /.modal-content -->
	          </div>
	          <!-- /.modal-dialog -->
	</div>
