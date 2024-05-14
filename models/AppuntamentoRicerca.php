<?php

namespace app\models;

use Yii;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Appuntamento;

/**
 * AppuntamentoRicerca represents the model behind the search form of `app\models\Appuntamento`.
 */
class AppuntamentoRicerca extends Appuntamento
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'id_caregiver', 'id_logopedista', 'id_utente'], 'integer'],
            [['data', 'stato'], 'safe'],
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
    public function search($params, $fissati)
    {
        $identity = new Account();

        $query = Appuntamento::find();
        $query->joinWith('logopedista');
        $query->joinWith('utente');

        if (Yii::$app->user->isGuest == False && $identity->isLogopedista(Yii::$app->user->identity->ruolo))
            $query->where(['Appuntamento.id_logopedista' => Yii::$app->user->identity->id]);
        else if (Yii::$app->user->isGuest == False && $identity->isCaregiver(Yii::$app->user->identity->ruolo))
            $query->where(['Appuntamento.id_caregiver' => Yii::$app->user->identity->id]);

        if ($fissati)
            $query->andWhere(['Appuntamento.stato' => 'CONFERMATO']);
        else
            $query->andWhere(['<>', 'Appuntamento.stato', 'CONFERMATO']);

        $query->andwhere('DATE(Appuntamento.data) >= DATE(CURRENT_TIME)');
        
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
            'id_caregiver' => $this->id_caregiver,
            'id_logopedista' => $this->id_logopedista,
            'id_utente' => $this->id_utente,
            'data' => $this->data,
        ]);

        $query->andFilterWhere(['like', 'stato', $this->stato]);

        return $dataProvider;
    }
}
