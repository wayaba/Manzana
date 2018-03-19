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
	public $nextvencimiento;
	
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id','codigo', 'fecha_inscripcion', 'tiene_apto_medico', 'estado', 'created_at', 'updated_at'], 'integer'],
            [['nombre', 'apellido', 'email', 'dni', 'facebook_id','telefono','telefono_emergencia','plan','nextvencimiento'], 'safe'],
        		
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
        
        //if(isset($params['uptodate'])||isset($params['due']))
        //{
        $query->joinWith(['nextvencimiento']);
        //}
        
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        	'sort'=> ['defaultOrder' => ['codigo'=>SORT_ASC]]
        ]);
        $dataProvider->sort->attributes['plan'] = [
        		'asc' => ['plan.nombre' => SORT_ASC],
        		'desc' => ['plan.nombre' => SORT_DESC],
        ];
        $dataProvider->sort->attributes['nextvencimiento'] = [
        		'asc' => ['vencimiento.fecha' => SORT_ASC],
        		'desc' => ['vencimiento.fecha' => SORT_DESC],
        ];
        
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

        $query->andFilterWhere(['like', 'socio.nombre', $this->nombre])
            ->andFilterWhere(['like', 'socio.apellido', $this->apellido])
            ->andFilterWhere(['like', 'socio.codigo', $this->codigo])
            ->andFilterWhere(['like', 'socio.email', $this->email])
            ->andFilterWhere(['like', 'socio.dni', $this->dni])
            ->andFilterWhere(['like', 'socio.telefono', $this->telefono])
            ->andFilterWhere(['like', 'socio.telefono_emergencia', $this->telefono_emergencia])
            ->andFilterWhere(['like', 'socio.facebook_id', $this->facebook_id])
        	->andFilterWhere(['like', 'plan.nombre', $this->plan]);
        	 
        if(isset($params['new'])){
        	$query->andWhere(['>', 'FROM_UNIXTIME(socio.created_at)', new Expression('NOW() - INTERVAL 30 DAY') ]);
        }
        if(isset($params['uptodate'])){
        	$query->andWhere(['>=', 'vencimiento.fecha', new Expression('NOW()') ]);
        }
        if(isset($params['due']))
        {
        	$query->andWhere(['<', 'vencimiento.fecha', new Expression('NOW()') ]);
        }
        if(isset($params['inactive']))
        {
        	$query->andWhere(['<', 'vencimiento.fecha', new Expression('NOW() - INTERVAL 60 DAY') ]);
        }
        

        return $dataProvider;
    }
}
