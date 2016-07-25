<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Socio;
use yii\db\Expression;

/**
 * SocioSearch represents the model behind the search form about `common\models\Socio`.
 */
class SocioSearch extends Socio
{
	public $plan;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','codigo', 'fecha_inscripcion', 'tiene_apto_medico', 'estado', 'created_at', 'updated_at'], 'integer'],
            [['nombre', 'apellido', 'email', 'dni', 'facebook_id','telefono','telefono_emergencia','plan'], 'safe'],
        		
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = Socio::find();

        // add conditions that should always apply here
        $query->joinWith(['plan']);
        
        if(isset($params['uptodate'])||isset($params['due']))
        {
        	$query->joinWith(['vencimientos']);
        }
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'sort'=> ['defaultOrder' => ['codigo'=>SORT_ASC]]
        ]);
        $dataProvider->sort->attributes['plan'] = [
        		'asc' => ['plan.nombre' => SORT_ASC],
        		'desc' => ['plan.nombre' => SORT_DESC],
        ];
        //$query->joinWith(['pago' => function($query) { $query->from(['author' => 'users']); }]);
        
        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
        	'codigo' => $this->codigo,
            'fecha_inscripcion' => $this->fecha_inscripcion,
            'tiene_apto_medico' => $this->tiene_apto_medico,
            'estado' => $this->estado,
        	'telefono' => $this->telefono,
        	'telefono_emergencia' => $this->telefono_emergencia,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        $query->andFilterWhere(['like', 'nombre', $this->nombre])
            ->andFilterWhere(['like', 'apellido', $this->apellido])
            ->andFilterWhere(['like', 'codigo', $this->codigo])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'dni', $this->dni])
            ->andFilterWhere(['like', 'telefono', $this->telefono])
            ->andFilterWhere(['like', 'telefono_emergencia', $this->telefono_emergencia])
            ->andFilterWhere(['like', 'facebook_id', $this->facebook_id])
        	->andFilterWhere(['like', 'plan.nombre', $this->plan]);
        
        if(isset($params['new'])){
        	$query->andWhere(['>', 'FROM_UNIXTIME(socio.created_at)', new Expression('NOW() - INTERVAL 30 DAY') ]);
        }
        if(isset($params['uptodate'])){
        	$query->andWhere(['is', 'vencimiento.pago_id' , null])
        		->andWhere(['>=', 'vencimiento.fecha', new Expression('NOW()') ]);
        }
        if(isset($params['due']))
        {
        	$query->andWhere(['is', 'vencimiento.pago_id' , null])
        	->andWhere(['<', 'vencimiento.fecha', new Expression('NOW()') ]);
        }
        	 

        return $dataProvider;
    }
}
