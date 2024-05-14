<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\EsercizioSvolto;

/**
 * EsercizioSvoltoRicerca represents the model behind the search form of `app\models\EsercizioSvolto`.
 */
class EsercizioSvoltoRicerca extends EsercizioSvolto
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_esercizio', 'id_terapia'], 'integer'],
            [['data', 'risposta', 'valutazione'], 'safe'],
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
        $query = EsercizioSvolto::find();
        $query->joinWith('esercizio');
        $query->where(['EsercizioSvolto.id_terapia' => Caregiver::trovaTerapiaUtente()]);
        $query->andWhere(['IS','EsercizioSvolto.valutazione', null]);

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
            'id_esercizio' => $this->id_esercizio,
            'id_terapia' => $this->id_terapia,
            'data' => $this->data,
        ]);

        $query->andFilterWhere(['like', 'risposta', $this->risposta])
            ->andFilterWhere(['like', 'valutazione', $this->valutazione]);

        return $dataProvider;
    }
}