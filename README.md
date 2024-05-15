## Logopedia System

### Descrizione

Sistema software dedicato a supportare l'operato dei logopedisti nella somministrazione e monitoraggio delle terapie. Questo sistema permette al logopedista di creare e monitorare terapie personalizzate per gli utenti, mentre consente ai caregiver di prenotare sedute e monitorare lo stato di avanzamento degli utenti assistiti. Gli utenti possono accedere alla piattaforma per svolgere gli esercizi assegnati e ricevere indicazioni dal logopedista, con l'incentivo di ricevere ricompense per il completamento degli esercizi.

### Design pattern utilizzati
- **Model View Controller (MVC)**

### Caratteristiche Principali

- Gestione personalizzata delle terapie per gli utenti
- Monitoraggio dell'andamento della terapia
- Prenotazione di sedute da parte dei caregiver
- Svolgimento degli esercizi e ricezione di indicazioni dagli utenti
- Sistema di ricompense per incentivare il completamento degli esercizi

### Entità Coinvolte

- **Logopedista**: Responsabile della diagnosi e creazione delle terapie.
- **Utente**: Segue la terapia e svolge gli esercizi assegnati.
- **Caregiver**: Assiste l'utente durante la terapia e comunica con il logopedista.

### Tecnologie Utilizzate

- Yii Framework: Framework PHP ad alte prestazioni per lo sviluppo di applicazioni web.

### Specifica delle Componenti

#### Views

Componente responsabile della visualizzazione dei dati e dell'interazione tra gli utenti e l'infrastruttura del sistema.

#### Controllers

Componente responsabile della logica di controllo del sistema.


#### Models

Componente dedicata alla gestione dei dati del sistema.

### Implementazioni Sprint Futuri

#### Comunica Caregiver - Comunica Logopedista
Implementazione di un sistema di chat remota istantanea tra caregiver e logopedista per facilitare la comunicazione e lo scambio di informazioni importanti.

#### Visualizza Ricompensa
Sviluppo di un sistema di ricompense personalizzabili per gli utenti, che potranno scegliere tra opzioni come link a video educativi o personalizzazione di avatar.

#### Completa Test Autodiagnosi
Integrazione di un questionario basato sulle Abilità Socio-Conversazionali del Bambino (ASCB) per il Test Autodiagnosi, con restituzione dei risultati relativi a possibili disturbi comunicativi e linguistici.

#### Effettua Diagnosi
Implementazione di una panoramica delle possibili diagnosi diagnosticabili dall'utente per il logopedista, che potrà confermare una diagnosi formulata dal sistema.

#### Assistito
Suddivisione dei pazienti in categorie, distinguendo tra utenti autosufficienti che non richiedono un caregiver per la gestione della terapia e coloro che necessitano di assistenza.

#### Registrazione Vocale
Introduzione della registrazione vocale nel sistema, consentendo agli utenti e ai caregiver di registrare e memorizzare l'audio per la convalida degli esercizi e il monitoraggio della terapia.
