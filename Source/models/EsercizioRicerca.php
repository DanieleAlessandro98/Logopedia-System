<?php

namespace app\models;

use Yii;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Esercizio;
use app\models\EsercizioSvolto;

/**
 * EsercizioRicerca represents the model behind the search form of `app\models\Esercizio`.
 */
class EsercizioRicerca extends Esercizio
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['nome', 'tipologia', 'disturbo', 'parola', 'fonema'], 'safe'],
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
    public function search($params, $id_terapia = -1, $aggiungi = false)
    {
        $query = Esercizio::find();

        if ($id_terapia !== -1)
        {
            if (!$aggiungi)
            {
                $query->andWhere('EXISTS (SELECT 1 FROM ListaEserciziTerapia WHERE id_esercizio = Esercizio.id AND id_terapia = :id_terapia)')
                ->params([
                    'id_terapia' => $id_terapia,
                ]);
            }
        }

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
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'tipologia', $this->tipologia])
            ->andFilterWhere(['like', 'disturbo', $this->disturbo])
            ->andFilterWhere(['like', 'parola', $this->parola])
            ->andFilterWhere(['like', 'fonema', $this->fonema]);
			
        return $dataProvider;
    }
	
    public function trovaEserciziTerapia($params)
    {
        $query = Esercizio::find();
        $query->joinWith('listaEserciziTerapia');
        $query->where(['ListaEserciziTerapia.id_terapia' => Utente::trovaTerapia()]);
        $query->andWhere('ListaEserciziTerapia.giorno = LOWER(DAYNAME(CURDATE()))');
        $query->andWhere(['not in', 'Esercizio.id', EsercizioSvolto::trovaEserciziSvoltiOggi()]);
        $query->andWhere('NOT EXISTS (SELECT 1 FROM EsercizioSvolto WHERE EsercizioSvolto.id_terapia = ListaEserciziTerapia.id_terapia AND EsercizioSvolto.id_esercizio = ListaEserciziTerapia.id_esercizio AND valutazione = "Giusta")');

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
        ]);

        $query->andFilterWhere(['like', 'nome', $this->nome])
            ->andFilterWhere(['like', 'tipologia', $this->tipologia])
            ->andFilterWhere(['like', 'disturbo', $this->disturbo])
            ->andFilterWhere(['like', 'parola', $this->parola])
            ->andFilterWhere(['like', 'fonema', $this->fonema]);
			
        return $dataProvider;
    }
}
