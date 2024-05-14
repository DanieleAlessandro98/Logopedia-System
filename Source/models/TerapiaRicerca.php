<?php

namespace app\models;

use app\models\Terapia;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * TerapiaRicerca represents the model behind the search form of `app\models\Terapia`.
 */
class TerapiaRicerca extends Terapia
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_utente'], 'integer'],
            [['nome', 'disturbo', 'stato'], 'safe'],
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
     * Restituisce il campo nome, disturbo e stato della terapia ottenuta per id
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        //effettua un join con l'utente relativo alla terapia
        $query = Terapia::find()->with('utente');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'id' => $this->id,
            'id_utente' => $this->id_utente,
            'nome' => $this->nome,
            'disturbo' => $this->disturbo,
            'stato' => $this->stato,
        ]);


        return $dataProvider;
    }

    public function getDatiTerapieByCaregiver($params)
    {
        //effettua un join con l'utente relativo alla terapia
        $query = Terapia::find()->joinWith('listaAssistiti')
            ->where(['ListaAssistiti.id_caregiver' => Yii::$app->user->identity->id]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'id' => $this->id,
            'id_utente' => $this->id_utente,
            'nome' => $this->nome,
            'disturbo' => $this->disturbo,
            'stato' => $this->stato,
        ]);


        return $dataProvider;
    }



    public function getDatiTerapie($params)
    {
        //effettua un join con l'utente relativo alla terapia
        $query = Terapia::find()->with('utente');

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }


        $query->andFilterWhere([
            'id' => $this->id,
            'id_utente' => $this->id_utente,
            'nome' => $this->nome,
            'disturbo' => $this->disturbo,
            'stato' => $this->stato,
        ]);


        return $dataProvider;
    }





}
