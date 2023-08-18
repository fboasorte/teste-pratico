<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Transacao;

/**
 * TransacaoSearch represents the model behind the search form of `app\models\Transacao`.
 */
class TransacaoSearch extends Transacao
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'tipo', 'data_hora', 'conta_origem_numero', 'conta_destino_numero'], 'integer'],
            [['valor'], 'number'],
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
        $query = Transacao::find();

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
            'tipo' => $this->tipo,
            'data_hora' => $this->data_hora,
            'valor' => $this->valor,
            'conta_origem_numero' => $this->conta_origem_numero,
            'conta_destino_numero' => $this->conta_destino_numero,
        ]);

        return $dataProvider;
    }
}
