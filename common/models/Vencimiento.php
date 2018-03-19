<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "vencimiento".
 *
 * @property integer $id
 * @property integer $socio_id
 * @property integer $pago_id
 * @property string $fecha
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Pago $pago
 * @property Socio $socio
 */
class Vencimiento extends \yii\db\ActiveRecord
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
        return 'vencimiento';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['socio_id', 'fecha'], 'required'],
            [['socio_id', 'pago_id', 'created_at', 'updated_at'], 'integer'],
            [['fecha'], 'safe'],
            [['pago_id'], 'exist', 'skipOnError' => true, 'targetClass' => Pago::className(), 'targetAttribute' => ['pago_id' => 'id']],
            [['socio_id'], 'exist', 'skipOnError' => true, 'targetClass' => Socio::className(), 'targetAttribute' => ['socio_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'socio_id' => 'Socio ID',
            'pago_id' => 'Pago ID',
            'fecha' => 'Fecha de último vencimiento',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPago()
    {
        return $this->hasOne(Pago::className(), ['id' => 'pago_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocio()
    {
        return $this->hasOne(Socio::className(), ['id' => 'socio_id']);
    }

    /**
     * @inheritdoc
     * @return VencimientoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VencimientoQuery(get_called_class());
    }
    
    public function beforeSave($insert) {
    
    	$date = \DateTime::createFromFormat ( 'd/m/Y' , $this->fecha );
    	if($date){
    		$this->fecha = $date->format('Y-m-d');
    	}
    	 
    
    	return parent::beforeSave($insert);
    }
    public function afterFind()
    {
    	$this->fecha = \DateTime::createFromFormat ( 'Y-m-d' , $this->fecha );
    	if($this->fecha ){
    		$this->fecha = $this->fecha ->format('d/m/Y');
    	}
    	 
    	parent::afterFind();
    }
}
