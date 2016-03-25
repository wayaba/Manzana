<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "configuracion".
 *
 * @property integer $id
 * @property string $valor_cuota
 * @property integer $created_at
 * @property integer $updated_at
 */
class Configuracion extends \yii\db\ActiveRecord
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
        return 'configuracion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['valor_cuota'], 'required'],
            [['valor_cuota'], 'number'],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'valor_cuota' => 'Valor Cuota',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @inheritdoc
     * @return ConfiguracionQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ConfiguracionQuery(get_called_class());
    }
}
