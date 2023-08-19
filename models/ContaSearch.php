<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Conta;

/**
 * ContaSearch represents the model behind the search form of `app\models\Conta`.
 */
class ContaSearch extends Conta
{
    public $tipo_conta;
    public $cliente;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['numero', 'tipo_conta_id', 'cliente_id'], 'integer'],
            [['saldo'], 'number'],
            [['tipo_conta', 'cliente'], 'safe']
        ];
    }

    /**
     * {@inheritdoc}
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
        $query = Conta::find()
            ->joinWith('tipoConta')
            ->joinWith('cliente');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $dataProvider->sort->attributes['tipo_conta'] = [
            'asc'  => ['tipo_conta.nome' => SORT_ASC],
            'desc' => ['tipo_conta.nome' => SORT_DESC],
        ];

        $dataProvider->sort->attributes['cliente'] = [
            'asc'  => ['cliente.nome' => SORT_ASC],
            'desc' => ['cliente.nome' => SORT_DESC],
        ];

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'numero' => $this->numero,
            'tipo_conta_id' => $this->tipo_conta_id,
            'saldo' => $this->saldo,
            'cliente_id' => $this->cliente_id,
        ]);

        $query->andFilterWhere(['ilike', 'banco.tipo_conta.nome', $this->tipo_conta]);
        $query->andFilterWhere(['ilike', 'banco.cliente.nome', $this->cliente]);
        

        return $dataProvider;
    }
}
