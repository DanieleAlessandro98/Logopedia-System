<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Listaassistiti;

/**
 * ListaAssistitiRicerca represents the model behind the search form of `app\models\Listaassistiti`.
 */
class ListaAssistitiRicerca extends Listaassistiti
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id_caregiver', 'id_utente'], 'integer'],
            [['nome', 'cognome', 'codice_fiscale'], 'safe'],
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
    public function search($params,$id_caregiver)
    {
        $query = Listaassistiti::find()->where(['id_caregiver'=>$id_caregiver]);

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
            'id_caregiver' => $this->id_caregiver,
            'id_utente' => $this->id_utente,
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'cognome', $this->cognome])
            ->andFilterWhere(['like', 'codice_fiscale', $this->codice_fiscale]);

        return $dataProvider;
    }
}
