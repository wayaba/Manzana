<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "pago".
 *
 * @property integer $id
 * @property integer $socio_id
 * @property integer $fecha_pago
 * @property integer $monto
 * @property integer $valor_cuota
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Socio $socio
 */
class Pago extends \yii\db\ActiveRecord
{
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
				TimestampBehavior::className(),
		];
	}
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'pago';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['socio_id', 'fecha_pago', 'monto', 'valor_cuota'], 'required'],
            [['socio_id', 'created_at', 'updated_at'], 'integer'],
        	[['monto', 'valor_cuota'], 'number'],
            [['socio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Socio::className(), 'targetAttribute' => ['socio_id' => 'id']],
        ];
    }
    public function beforeSave($insert) {
    
    	$date = \DateTime::createFromFormat ( 'd/m/Y' , $this->fecha_pago );
    	if($date){
    		$this->fecha_pago = $date->format('Y-m-d');
    	}
    	
    	return parent::beforeSave($insert);
    }
    public function afterFind()
    {
    	$this->fecha_pago= \DateTime::createFromFormat ( 'Y-m-d' , $this->fecha_pago );
    	if($this->fecha_pago){
    		$this->fecha_pago = $this->fecha_pago->format('d/m/Y');
    	}
    	 
    	parent::afterFind();
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'socio_id' => 'Socio',
            'fecha_pago' => 'Fecha Pago',
            'monto' => 'Monto',
            'valor_cuota' => 'Valor Cuota',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocio()
    {
        return $this->hasOne(Socio::className(), ['id' => 'socio_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVencimiento()
    {
    	return $this->hasOne(Vencimiento::className(), ['pago_id' => 'id']);
    }
    
    /**
     * @inheritdoc
     * @return PagoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PagoQuery(get_called_class());
    }
}
