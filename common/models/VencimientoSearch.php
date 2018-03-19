<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Vencimiento;

/**
 * VencimientoSearch represents the model behind the search form about `common\models\Vencimiento`.
 */
class VencimientoSearch extends Vencimiento
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'socio_id', 'pago_id', 'created_at', 'updated_at'], 'integer'],
            [['fecha'], 'safe'],
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
        $query = Vencimiento::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'socio_id' => $this->socio_id,
            'pago_id' => $this->pago_id,
            'fecha' => $this->fecha,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ]);

        return $dataProvider;
    }
}
