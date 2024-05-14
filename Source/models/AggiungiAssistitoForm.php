<?php

namespace app\models;

use Yii;
use yii\base\Model;

class AggiungiAssistitoForm extends Model
{
    public $codice_fiscale;

    public function rules()
    {
        return [
            // codice_fiscale are both required
            ['codice_fiscale', 'required'],
        ];
    }

    public function aggiungiAssistito()
    {
        $utente = Utente::trovaUtenteByCodiceFiscale($this->codice_fiscale);

        if ($utente == null) {
            Yii::warning('test2');
            return null;
        }
            
            
        $paziente = new Paziente();

        // 1 = simula id logopedista (che sarà loggato, quindi sistema otterrà direttamente id)
        $paziente->id_utente = $utente->id;
        $paziente->id_logopedista = 4;

        $paziente->save();

        return $utente;
    }
}
