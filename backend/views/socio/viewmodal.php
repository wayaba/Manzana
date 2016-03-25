<?php

use yii\widgets\DetailView;
use yii\helpers\Html;

?>

<div class="modal fade" id="view-modal">
	          <div class="modal-dialog">
	            <div class="modal-content">
	              <div class="modal-header">
	                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
	                  <span aria-hidden="true">&times;</span></button>
	                <h4 class="modal-title">Detalle del socio</h4>
	              </div>
	              <div class="modal-body">
	              	<div class="row-fluid">
	              	<div class="span12">
	              	<div class="box box-success">
	              	<div class="box-body">
						<?= DetailView::widget([
					        'model' => $model,
					        'attributes' => [
					            'nombre',
					            'apellido',
					            'fecha_inscripcion',
					        	'fecha_nacimiento',
					        	'telefono',
					        	'telefono_emergencia',
					            'email:email',
					            'dni',
					        	[ 
					        		'attribute' => 'tiene_apto_medico',
					        		'value' => $model->tiene_apto_medico?'Si':'No',
					        	],
					        	'fecha_vencimiento_apto_medico',
					        	[
					        		'attribute' => 'estado',
					        		'value' => $model->estado?'Activo':'Inactivo',
					        	],
					        		
					        	[
					        		'attribute' => 'facebook_id',
					        		'format' => ['raw'],
					        		'value' => '<a target="_blank" href="http://facebook.com/'.$model->facebook_id.'"> '.$model->facebook_id.'</a>',
					        	],
					        ],
					    ]) ?>
					    </div>
					    </div>
					    </div>
		              </div>
	              </div>
	              <div class="modal-footer">
	                <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Close</button>
	              </div>
	            </div>
	            <!-- /.modal-content -->
	          </div>
	          <!-- /.modal-dialog -->
	</div>
