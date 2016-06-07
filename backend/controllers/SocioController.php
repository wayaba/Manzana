<?php

namespace backend\controllers;

use Yii;
use common\models\Socio;
use common\models\SocioSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Json;
use yii\web\JsonResponseFormatter;
use common\models\Pago;
use common\models\Configuracion;
use yii\bootstrap\ActiveForm;
use common\models\Vencimiento;
use yii\db\Query;
use yii\db\Expression;
use common\models\PagoSearch;

/**
 * SocioController implements the CRUD actions for Socio model.
 */
class SocioController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Socio models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SocioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Lists all Pago models.
     * @return mixed
     */
    public function actionStats()
    {
    	$searchModel = new SocioSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    
    	$query = new Query();
    	$vencimientosUptodate = $query->select('1')
    	->from('vencimiento')
    	->andWhere(['is', 'pago_id' , null])
    	->andWhere(['>=', 'fecha', new Expression('NOW()') ])
    	->count();
    
    	$query = new Query();
    	$vencimientosDue = $query->select('1')
    	->from('vencimiento')
    	->andWhere(['is', 'pago_id' , null])
    	->andWhere(['<', 'fecha', new Expression('NOW()') ])
    	->count();
    
    	$query = new Query();
    	$newSocios = $query->select('*')
    	->from('socio')
    	->andWhere(['>', 'FROM_UNIXTIME(created_at)', new Expression('NOW() - INTERVAL 30 DAY') ])
    	->count();
    
    	return $this->render('stats', [
    			'searchModel' => $searchModel,
    			'dataProvider' => $dataProvider,
    			'vencimientosUptodate'=>$vencimientosUptodate,
    			'vencimientosDue'=>$vencimientosDue,
    			'newSocios'=>$newSocios
    	]);
    }
    
    /**
     * Displays a single Socio model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Socio model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Socio();
        
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        	return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post())) {
        	if($model->save())
        	{
            	return $this->redirect(['index']);
        	}
        } else {
        	
        	$codigo = Socio::find()->max('codigo');
        	
        	$model->codigo = ((isset($codigo)?$codigo:1000) + 1);        	
        	$model->fecha_inscripcion = date ( 'd/m/Y' );
        	$model->fecha_vencimiento_apto_medico = date ( 'd/m/Y' , strtotime('+1 years'));
        	$model->estado = 1;
        	 
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Socio model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
        	Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        	return ActiveForm::validate($model);
        }
        
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }
    
    public function actionShowModal()
    {
    	if(Yii::$app->request->isAjax)
    	{
	    	$model = $this->findModel(Yii::$app->request->post('id'));
    		return $this->renderPartial('viewmodal',['model'=>$model]);
    	}
    	 
    }
    public function actionShowDueDateModal()
    {
    	if(Yii::$app->request->isAjax)
    	{
    		$model = $this->findModel(Yii::$app->request->post('id'));
    		return $this->renderPartial('duedatemodal',['model'=>$model]);
    	}
    
    }
    
    
    public function actionShowPayModal()
    {
    	if(Yii::$app->request->isAjax)
    	{
    		$model = $this->findModel(Yii::$app->request->post('id'));
    		return $this->renderPartial('paymodal',['model'=>$model]);
    	}
    
    }
    public function actionMakePayment()
    {
    	if(Yii::$app->request->isAjax)
    	{
    		$pago = Yii::$app->request->post('Pago');
    		$socio = $this->findModel($pago['socio_id']);
    		
    		$vencimiento = Vencimiento::find()->where(['socio_id' => $socio->id])
    		 ->andWhere(['is' , 'pago_id' , null])->one();
    		
    		if(!isset($vencimiento))
    		{
    			if(Yii::$app->request->post('Vencimiento',false))
    			{
    				$vencimiento = new Vencimiento();
    				$vencimiento->load(Yii::$app->request->post());
    				$vencimiento->socio_id = $socio->id;
    				$vencimiento->save();
    				
    			}
    			else
    			{
    				$vencimiento = new Vencimiento();
    				$vencimiento->socio_id = $socio->id;
    				$vencimiento->fecha = $socio->fecha_inscripcion;
    				$vencimiento->save();
    				
    			}
   				$fecha_vencimiento_anterior = \DateTime::createFromFormat ( 'Y-m-d' , $vencimiento->fecha );
    		}
    		else
    		{
    			$fecha_vencimiento_anterior = \DateTime::createFromFormat ( 'd/m/Y' , $vencimiento->fecha );
    		}
    		
   			$pagoModel = new Pago();
   			$pagoModel->load(Yii::$app->request->post());
   			$pagoModel->fecha_pago = date ( 'd/m/Y' );
    			 
   			if ($pagoModel->save()) {
   				$vencimiento->pago_id = $pagoModel->id;
   				$vencimiento->save();
   				
   				$vencimiento = new Vencimiento();
   				$vencimiento->socio_id = $socio->id;
   				$fecha_vencimiento_anterior->add(new \DateInterval('P1M'));
   				$vencimiento->fecha = $fecha_vencimiento_anterior->format('d/m/Y');
   				$vencimiento->save();
   					
   				return Json::encode($pagoModel->attributes);
   			}
    	}
    
    }
    public function actionChangeDueDate()
    {
    	if(Yii::$app->request->isAjax)
    	{
    		$vencimiento = new Vencimiento();
    		$vencimiento->load(Yii::$app->request->post());
    		$socio = $this->findModel($vencimiento['socio_id']);
    		    
    		$vencimiento = Vencimiento::find()->where(['socio_id' => $socio->id])
    		->andWhere(['is' , 'pago_id' , null])->one();
    
    		if(isset($vencimiento))
    		{
    			if(Yii::$app->request->post('Vencimiento',false))
    			{
    				$vencimiento->load(Yii::$app->request->post());
    				$vencimiento->save();
    
    			}
    		}
    	}
    
    }
    

    /**
     * Deletes an existing Socio model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Socio model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Socio the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Socio::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
