<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "socio".
 *
 * @property integer $id
 * @property string $nombre
 * @property string $apellido
 * @property date $fecha_inscripcion
 * @property date fecha_vencimiento_apto_medico
 * @property string $email
 * @property string $dni
 * @property integer $tiene_apto_medico
 * * @property integer $sexo
 * @property integer $estado
 * @property string $facebook_id
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property Pago[] $pagos
 */
class Socio extends \yii\db\ActiveRecord
{
	const STATUS_INACTIVE	= 0;
	const STATUS_ACTIVE		= 1;
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
        return 'socio';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['nombre', 'apellido','plan_id'], 'required'],
            [['tiene_apto_medico', 'codigo' ,'estado', 'sexo', 'created_at', 'updated_at','plan_id'], 'integer'],
            [['nombre', 'apellido', 'email', 'facebook_id','telefono','telefono_emergencia'], 'string', 'max' => 100],
            [['direccion_calle', 'direccion_numero', 'direccion_localidad', 'direccion_provincia','direccion_codigo_postal','direccion_departamento'], 'string', 'max' => 100],        		
            [['dni','fecha_inscripcion','fecha_nacimiento','fecha_vencimiento_apto_medico'], 'string', 'max' => 20],
            [['email','facebook_id'], 'unique'],
        	[['email'], 'email'],
        	[['facebook_id','email'], 'default'],
        ];
    }
    public function beforeSave($insert) {

    	$date = \DateTime::createFromFormat ( 'd/m/Y' , $this->fecha_inscripcion );
    	if($date){
    		$this->fecha_inscripcion = $date->format('Y-m-d');
    	}
    	
    	$date = \DateTime::createFromFormat ( 'd/m/Y' , $this->fecha_nacimiento );
    	if($date)
    	{
    		$this->fecha_nacimiento = $date ->format('Y-m-d');
    	}
    	
    	$date = \DateTime::createFromFormat ( 'd/m/Y' , $this->fecha_vencimiento_apto_medico);
    	if($date)
    	{
    		$this->fecha_vencimiento_apto_medico = $date->format('Y-m-d');
    	}
    	 
   	
    	return parent::beforeSave($insert);
    }
    public function afterFind()
    {
    	$this->fecha_inscripcion= \DateTime::createFromFormat ( 'Y-m-d' , $this->fecha_inscripcion );
    	if($this->fecha_inscripcion){
    		$this->fecha_inscripcion = $this->fecha_inscripcion->format('d/m/Y');
    	}

    	$this->fecha_nacimiento= \DateTime::createFromFormat ( 'Y-m-d' , $this->fecha_nacimiento );
    	if($this->fecha_nacimiento){
    		$this->fecha_nacimiento = $this->fecha_nacimiento->format('d/m/Y');
    	}
    	 
    	$this->fecha_vencimiento_apto_medico= \DateTime::createFromFormat ( 'Y-m-d' , $this->fecha_vencimiento_apto_medico );
    	if($this->fecha_vencimiento_apto_medico){
    		$this->fecha_vencimiento_apto_medico = $this->fecha_vencimiento_apto_medico->format('d/m/Y');
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
            'nombre' => 'Nombre',
            'apellido' => 'Apellido',
            'fecha_inscripcion' => 'Fecha Inscripcion',
            'fecha_nacimiento' => 'Fecha Nacimiento',
        	'email' => 'Email',
            'dni' => 'DNI',
        	'telefeno' => 'Teléfono',
        	'telefeno' => 'Tel. emergencias',
            'estado' => 'Estado',
        	'codigo' => 'Nro. Socio',
            'facebook_id' => 'Facebook',
        	'fecha_vencimiento_apto_medico'=> 'Venc. Apto Médico',
        	'direccion_calle' => 'Calle',
        	'direccion_numero' => 'Número',
        	'direccion_localidad' => 'Localidad',
        	'direccion_provincia' => 'Provincia',
        	'direccion_codigo_postal' => 'Código Postal',
        	'direccion_departamento'=> 'Departamento',
        	'plan_id'=>'Plan',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        	'nextvencimiento'=>'Próximo vencimiento'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPagos()
    {
        return $this->hasMany(Pago::className(), ['socio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPlan()
    {
    	return $this->hasOne(Plan::className(), ['id' => 'plan_id']);
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getVencimientos()
    {
    	return $this->hasMany(Vencimiento::className(), ['socio_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getNextvencimiento()
    {
    	return $this->hasOne(Vencimiento::className(), ['socio_id' => 'id'])->andOnCondition(['is', 'vencimiento.pago_id' , null]);
    }
    
    
    /**
     * @inheritdoc
     * @return SocioQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new SocioQuery(get_called_class());
    }
    public function getfecha_ultimo_pago()
    {
    	$pago = Pago::find()
    	->where(['socio_id' => $this->id])
    	->orderBy('created_at','desc')
    	->one();
    	 
    	if(isset($pago))
    	{
    		$created = new \DateTime();
    		$created->setTimestamp($pago->created_at);
    		return $created->format('d/m/Y');
    	}
    	else
    	{
    		return 'Pendiente';
    	}
    	 
    }
    public function getFecha_proximo_vencimiento()
    {
    	$vencimiento = Vencimiento::find()->where(['socio_id' => $this->id])
    	->andWhere(['is' , 'pago_id' , null])->one();
    	 
    	if(isset($vencimiento))
    	{
    		return $vencimiento->fecha;
    	}
    	else
    	{
    		return 'Pendiente';
    	}
    
    }
    
    
}
