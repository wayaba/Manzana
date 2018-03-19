<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "plan".
 *
 * @property integer $id
 * @property integer $configuracion_id
 * @property string $valor_cuota
 * @property string $nombre
 * @property string $descripcion
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Configuracion $configuracion
 * @property Socio[] $socios
 */
class Plan extends \yii\db\ActiveRecord
{
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
        return 'plan';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['configuracion_id', 'valor_cuota', 'nombre'], 'required'],
            [['configuracion_id', 'created_at', 'updated_at'], 'integer'],
            [['valor_cuota'], 'number'],
            [['descripcion'], 'string'],
            [['nombre'], 'string', 'max' => 255],
            [['configuracion_id'], 'exist', 'skipOnError' => true, 'targetClass' => Configuracion::className(), 'targetAttribute' => ['configuracion_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'configuracion_id' => 'Configuracion ID',
            'valor_cuota' => 'Valor Cuota',
            'nombre' => 'Nombre',
            'descripcion' => 'Descripcion',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getConfiguracion()
    {
        return $this->hasOne(Configuracion::className(), ['id' => 'configuracion_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSocios()
    {
        return $this->hasMany(Socio::className(), ['plan_id' => 'id']);
    }

    /**
     * @inheritdoc
     * @return PlanQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlanQuery(get_called_class());
    }
    
    public function getformated_nombre()
    {
    	return $this->nombre . ' ( $ ' .$this->valor_cuota .' )';  
    }
}
