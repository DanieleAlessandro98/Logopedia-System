<?php

namespace app\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\TestAutodiagnosi;

/**
 * TestAutodiagnosiRicerca represents the model behind the search form of `app\models\TestAutodiagnosi`.
 */
class TestAutodiagnosiRicerca extends TestAutodiagnosi
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['domanda_1', 'domanda_2', 'domanda_3', 'domanda_4'], 'safe'],
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
        $query = TestAutodiagnosi::find();

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andFilterWhere([
            'id' => $this->id,
        ]);

        $query->andFilterWhere(['like', 'domanda_1', $this->domanda_1])
            ->andFilterWhere(['like', 'domanda_2', $this->domanda_2])
            ->andFilterWhere(['like', 'domanda_3', $this->domanda_3])
            ->andFilterWhere(['like', 'domanda_4', $this->domanda_4]);

        return $dataProvider;
    }
}
