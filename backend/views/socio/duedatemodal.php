<?php

use yii\widgets\DetailView;
use common\models\Pago;
use yii\bootstrap\ActiveForm;
use common\models\Configuracion;
use common\models\Vencimiento;
use yii\web\View;
?>

<div class="modal fade" id="view-modal">
	          <div class="modal-dialog">
	            <div class="modal-content">
	              <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Cambio de fecha de vencimiento</h4>
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
				        	[
				        		'attribute' => 'Fecha Vencimiento',
				        		'label' => 'Fecha Vencimiento',
				        		'value' => $model->fecha_proximo_vencimiento,
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
					
					<?php $form = ActiveForm::begin(['action' => ['socio/change-due-date'],'id'=>'change-due-date-form']); ?>
					<?php
					$vencimientoModel = new Vencimiento();

					$vencimientoModel->socio_id = $model->id;
						
					?>
	              	<div class="box-header with-border">
	              		<h3 class="box-title">Cargue la nueva fecha de vencimiento</h3>
	              	</div>

	              	<div class="box-body">
	
				    <?= $form->field($vencimientoModel, 'socio_id')->hiddenInput()->label(false) ?>

					<?php 
					$vencimiento = Vencimiento::find()->where(['socio_id' => $model->id])->andWhere(['is' , 'pago_id' , null])->one();
					if(isset($vencimiento)){
					?>
					<div class="row">
						<div class="col-md-12">
	    				<?= $form->field($vencimiento, 'fecha')->textInput(['class'=>'form-control datepicker'])->label(false) ?>
	    				</div>
					</div>
					<?php }?>
				    <?php ActiveForm::end(); ?>
					
				    </div>
				    </div>
				    </div>
				    </div>
	              </div>
	              <div class="modal-footer">
	              <div class="btn-group">
	                <button type="button" onclick="changeDueDate()" class="btn btn-success change-due-date" > Grabar</button>
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
<script type="text/javascript">
	$('.datepicker').datepicker({language: 'es', format: 'dd/mm/yyyy',autoclose:true});		
</script>
	