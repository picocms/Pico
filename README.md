Pico
====

[![License](https://picocms.github.io/badges/pico-license.svg)](https://github.com/picocms/Pico/blob/master/LICENSE.md)
[![Version](https://picocms.github.io/badges/pico-version.svg)](https://github.com/picocms/Pico/releases/latest)
[![Build Status](https://api.travis-ci.org/picocms/Pico.svg?branch=master)](https://travis-ci.org/picocms/Pico)
[![Freenode IRC Webchat](https://picocms.github.io/badges/pico-chat.svg)](https://webchat.freenode.net/?channels=%23picocms)
[![Open Bounties on Bountysource](https://www.bountysource.com/badge/team?team_id=198139&style=bounties_received)](https://www.bountysource.com/teams/picocms)

Pico è un CMS stupidamente semplice, incredibilmente veloce, basato su files di testo.

Visitate il sito http://picocms.org/ e date un'occhiata a http://picocms.org/about/ per maggiori informazioni.

Schermata
----------

[Pico Screenshot](https://picocms.github.io/screenshots/pico-20.png)

Installazione
-------

L'installazione di Pico è semplicissima - e dura pochi secondi! Se si ha accesso a una shell sul proprio server (cioè accesso SSH), si consiglia di usare [Composer][]. In caso contrario, utilizzare una versione pre-bundled. Se non sai cos'è l'"accesso SSH", punta alla versione pre-bundled. 😇

Pico richiede PHP 5.3.6+.

### Voglio usare Composer

A partire da Pico 2.0 si consiglia di installare Pico utilizzando Composer quando possibile. Fidatevi di noi, non ve ne pentirete quando si tratta di aggiornare Pico! In ogni caso, se non vuoi usare Composer, o se semplicemente non puoi usare Composer perché non hai accesso a una shell sul tuo server, non disperare, installare Pico usando una release pre-bundled è comunque più facile di qualsiasi altra cosa tu conosca!

###### Passo 1

Aprire una shell e navigare fino alla directory `httpdocs` (ad esempio `/var/var/www/html`) del server. Scaricare Composer ed eseguirlo con l'opzione `create-project` per installarlo nella directory desiderata (ad esempio `/var/www/html/pico`):

````shell
$ curl -sSL https://getcomposer.org/installer | php
$ php composer.phar create-project picocms/pico-composer pico
```

###### Passo 2

Quale secondo passo? Non c'è un secondo passo. Questo è tutto! Apri il tuo browser web preferito e naviga verso il tuo nuovo CMS stupidamente semplice, incredibilmente veloce e basato su files di testo. I contenuti di esempio di Pico spiegheranno come creare i tuoi contenuti. 😊

### Voglio usare una versione pre-bundled

Conoscete la sensazione: Vuoi installare un nuovo sito web, quindi carichi tutti i file del tuo CMS preferito ed esegui lo script di setup - solo per scoprire che hai dimenticato di creare prima il database SQL? In seguito lo script di setup ti dice che i permessi dei file sono sbagliati. Che cavolo, non so neanche cosa siano i permessi dei file! Lascia perdere, Pico è diverso!

###### Passo 1

Scarica l'ultima versione di Pico][LatestRelease] e carica tutti i file nella cartella di installazione di Pico desiderata all'interno della cartella `httpdocs` (ad esempio `/var/wwwww/html/pico`) del tuo server.

###### Passo 2

Ok, ecco la fregatura: Non c'è la fregatura. È già finita qui! Apri il tuo browser web preferito e naviga verso il tuo nuovo CMS stupidamente semplice, incredibilmente veloce e basato su files di testo! I contenuti di esempio di Pico spiegheranno come creare i vostri contenuti. 😊

### Sono uno sviluppatore

Quindi, tu sei una di quelle persone fantastiche che rendono tutto questo possibile? Vi vogliamo bene, ragazzi! Come sviluppatori vi raccomandiamo di clonare il [repository Git di Pico][PicoGit] così come i repository Git del [tema predefinito di Pico][PicoThemeGit] e il [plugin `PicoDeprecated`][PicoDeprecatedGit]. Puoi impostare il tuo spazio di lavoro usando [Pico Composer starter project][PicoComposerGit] e includere tutti i componenti di Pico usando pacchetti locali.

L'uso dei repository Git di Pico è diverso dall'uso di uno dei metodi di installazione descritti sopra. Fornisce l'attuale versione di sviluppo di Pico, che probabilmente è *instabile* e *non pronta per l'uso in produzione*!

1. Apri una shell e naviga fino alla directory desiderata dello spazio di lavoro di sviluppo di Pico all'interno della directory `httpdocs` (ad esempio `/var/www/html/pico`) del server. Scarica ed estrai il progetto Composer starter di Pico nella directory `workspace`:

     ```shell
    $ curl -sSL https://github.com/picocms/pico-composer/archive/master.tar.gz | tar xz
    $ mv pico-composer-master workspace
    ```

2. Clona i repository Git di tutti i componenti Pico (il nucleo di Pico, il tema predefinito di Pico e il plugin `PicoDeprecated`) nella directory `componenti`:

    ```shell
    $ mkdir components
    $ git clone https://github.com/picocms/Pico.git components/pico
    $ git clone https://github.com/picocms/pico-theme.git components/pico-theme
    $ git clone https://github.com/picocms/pico-deprecated.git components/pico-deprecated
    ```

3. Istruisci il compositore ad usare i repository locali di Git in sostituzione dei pacchetti `picocms/pico` (il nucleo di Pico), `picocms/pico-theme` (il tema predefinito di Pico) e `picocms/pico-deprecated` (il plugin `PicoDeprecated`). Aggiorna `composer.json` nel tuo spazio di lavoro di sviluppo (cioè `workspace/composer.json`) di conseguenza:

    ```json
    {
        "repositories": [
            {
                "type": "path",
                "url": "../components/pico",
                "options": { "symlink": true }
            },
            {
                "type": "path",
                "url": "../components/pico-theme",
                "options": { "symlink": true }
            },
            {
                "type": "path",
                "url": "../components/pico-deprecated",
                "options": { "symlink": true }
            }
        ],
        "require": {
            "picocms/pico": "dev-master",
            "picocms/pico-theme": "dev-master",
            "picocms/pico-deprecated": "dev-master",
            "picocms/composer-installer": "^1.0"
        }
    }
    ```

4. 4. Scaricare Composer ed eseguirlo con l'opzione `install`:

```shell
    $ curl -sSL https://getcomposer.org/installer | php
    $ php composer.phar --working-dir=workspace install
    ```

Ora puoi aprire il tuo browser web e navigare nell'area di lavoro di sviluppo di Pico. Tutte le modifiche apportate ai componenti di Pico si riflettono automaticamente nell'area di lavoro di sviluppo.

A proposito, puoi anche trovare tutti i componenti di Pico su [Packagist.org][Packagist]: [Pico's core][PicoPackagist], [Pico's default theme][PicoThemePackagist], [PicoDeprecated` plugin][PicoDeprecatedPackagist] e [Pico's Composer starter project][PicoComposerPackagist].

Aggiornare
-------

Ti ricordi quando hai installato Pico? Era ingegnosamente semplice, vero? L'aggiornamento di Pico non fa alcuna differenza! Il processo di aggiornamento varia a seconda che tu abbia usato [Composer][] o una versione pre-bundled per installare Pico. Si prega di notare che si dovrebbe *sempre* creare un backup della propria installazione Pico prima dell'aggiornamento!

Pico segue [Semantic Versioning 2.0][SemVer] e utilizza numeri di versione come `MAJOR`.`MINOR`.`PATCH`. Quando aggiorniamo la versione `PATCH` (ad esempio da `2.0.0` a `2.0.1`), abbiamo effettuato correzioni di bug con piena retrocompatibilità. Se cambiamo la versione `MINOR` (ad es. da `2.0` a `2.1`), abbiamo aggiunto funzionalità in modo retrocompatibile. L'aggiornamento di Pico è semplice in entrambi i casi. Basta dirigersi verso le sezioni di aggiornamento appropriate qui sotto.

Ma aspetta, ci siamo dimenticati di menzionare cosa succede quando aggiorniamo la versione `MAJOR` (es. da `2.0` a `3.0`). In questo caso abbiamo apportato modifiche API incompatibili. Forniremo quindi un tutorial di aggiornamento appropriato, quindi si prega di recarsi alla pagina ["Upgrade" sul nostro sito web][HelpUpgrade].

### Ho usato Composer per installare Pico

L'aggiornamento di Pico è semplicissimo se hai usato Composer per installare Pico. Basta aprire una shell e navigare nella directory di installazione di Pico all'interno della directory `httpdocs` (ad esempio `/var/wwwww/html/pico`) del server. Ora è possibile aggiornare Pico usando solo un singolo comando:

````shell
$ php composer.phar update
```

Basta così! Composer aggiornerà automaticamente Pico e tutti i plugin e i temi che hai installato usando Composer. Assicurati di aggiornare manualmente tutti i plugin e i temi che hai installato manualmente.

### Ho usato una versione pre-bundled per installare Pico

Ok, installare Pico è stato facile, ma aggiornare Pico sarà difficile, non è vero? Ho paura di dovervi deludere... È semplice tanto quanto installare Pico!

Per prima cosa dovrai cancellare la directory `vendor` della tua installazione di Pico (ad esempio, se hai installato Pico in `/var/www/html/pico`, cancella `/var/www/html/pico/vendor`). Poi [scarica l'ultima versione di Pico][LatestRelease] e carica tutti i file nella directory di installazione di Pico esistente. Ti verrà chiesto se vuoi sovrascrivere file come `index.php`, `.htaccess`, .... - premi semplicemente "Sì".

Questo è quanto! Ora che Pico è aggiornato, è necessario che aggiorni tutti i plugin e i temi che hai installato.

### Sono uno sviluppatore

Come sviluppatore dovresti conoscere l'importanza di rimanere aggiornati... 😉 Per completezza, se si desidera aggiornare Pico, è sufficiente aprire una shell e navigare nello spazio di lavoro di sviluppo di Pico (ad esempio `/var/var/wwww/html/pico`). Quindi estrai gli ultimi commits dai repository Git di [Pico core][PicoGit], [Pico's default theme][PicoThemeGit] e [PicoDeprecated` plugin][PicoDeprecatedGit]. Lascia che Composer aggiorni le tue dependencies e sei pronto a partire.

```shell
$ git -C components/pico pull
$ git -C components/pico-theme pull
$ git -C components/pico-deprecated pull
$ php composer.phar --working-dir=workspace update
```

Come ottenere aiuto
------------

#### Ottenere aiuto come utente

Se si desidera iniziare ad usare Pico, fare riferimento alla nostra [sezione documenti][HelpUserDocs]. Prego leggere le [note di aggiornamento][HelpUpgrade] se si desidera passare da Pico 1.0 a Pico 2.0. Puoi trovare [plugin][OfficialPlugins] e [temi][OfficialThemes] ufficialmente supportati sul nostro sito web. Una maggiore scelta di plugin e temi di terze parti può essere trovata nelle nostre pagine [Wiki][], rispettivamente sulle pagine [plugin][WikiPlugins] o [temi][WikiThemes]. Se si desidera creare il proprio plugin o tema, si prega di fare riferimento alla sezione "Ottenere aiuto come sviluppatore" qui sotto.

#### Ottenere aiuto come sviluppatore

Se sei uno sviluppatore, fai riferimento alla sezione "Contribuire" qui sotto e alle nostre [linee guida ai contributi][ContributionGuidelines]. Per iniziare a creare un plugin o un tema, si prega di leggere i [documenti per gli sviluppatori sul nostro sito web][HelpDevDocs].

#### Hai ancora bisogno di aiuto o hai problemi con Pico?

Quando i documenti non possono rispondere alla tua domanda, puoi ottenere aiuto unendoti a noi su [#picocms su Freenode IRC][Freenode] ([logs][FreenodeLogs]). Quando hai problemi con Pico, non esitare a creare una nuova [Issue][Issues] su GitHub. Per problemi con plugin o temi, si prega di fare riferimento al sito web dello sviluppatore di questo plugin o tema.

**Prima di creare una nuova Issue,** assicurarsi che il problema non sia stato ancora segnalato utilizzando [motore di ricerca GitHub][IssuesSearch]. Descrivi il tuo problema nel modo più chiaro possibile e includi sempre la versione *Pico* che stai usando. Se stai usando *plugins*, includi anche un elenco di essi. Abbiamo bisogno di informazioni sul *comportamento effettivo e previsto*, sui *passi per riprodurre* il problema e sulle misure che hai preso per risolvere il problema da solo (cioè *la tua risoluzione dei problemi*).

Contribuire
------------

Vuoi contribuire a Pico? Lo apprezziamo molto! Puoi contribuire a rendere Pico migliore [contribuendo al codice][PullRequests] o [segnalando problemi][Issues], ma ti preghiamo di prendere nota delle nostre [linee guida per i contributi][ContributionGuidelines]. In generale, è possibile contribuire in tre diverse aree:

1. Plugin e temi: Sei uno sviluppatore di plugin o un designer di temi? Vi vogliamo bene, ragazzi! Potete trovare un sacco di informazioni su come sviluppare plugin e temi su http://picocms.org/development/. Se hai creato un plugin o un tema, per favore aggiungilo al nostro [Wiki][], sia nella pagina [plugins][WikiPlugins] o [themes][WikiThemes]. Puoi anche [Inviarlo][] al nostro sito web, dove sarà visualizzato sulle pagine ufficiali [plugin][OfficialPlugins] o [temi ufficiali][OfficialThemes]!

2. Documentazione: Apprezziamo sempre le persone che migliorano la nostra documentazione. È possibile migliorare i [Documenti utente in linea][EditInlineDocs] o i più ampi [Documenti utente sul nostro sito web][EditUserDocs]. È inoltre possibile migliorare i [doc per gli sviluppatori di plugin e temi][EditDevDocs]. Basta inserire il fork del nostro sito web nel repository Git da https://github.com/picocms/picocms.github.io, cambiare i file Markdown e aprire una [pull request][PullRequestsWebsite].

3. Il nucleo di Pico: La disciplina suprema è quella di lavorare sul Core di Pico. Il tuo contributo dovrebbe aiutare *ogni* utente Pico ad avere una migliore esperienza con Pico. In questo caso, fork Pico da https://github.com/picocms/Pico e apri una [richiesta di pull][PullRequests]. Saremo lieti di ricevere il vostro contributo!

Contribuendo a Pico, accetti e accetti il *certificato di origine dello sviluppatore* per i tuoi contributi presenti e futuri inviati a Pico. Si prega di fare riferimento alla sezione ["Certificato di origine dello sviluppatore" nella nostra "CONTRIBUTING.md`][ContributionGuidelinesDCO].

Non hai tempo per contribuire al codice di Pico, ma vuoi comunque "offrire un caffè" per coloro che lo fanno? Puoi contribuire finanziariamente a Pico usando [Bountysource][], un sito web di crow funding che si concentra su singole questioni e richieste di funzionalità. Basta fare riferimento alla sezione "Bounties and Fundraisers" qui sotto per maggiori informazioni.

Ricompense e Raccolte fondi
---------------------------

Pico utilizza [Bountysource][] per consentire contributi monetari al progetto. Bountysource è un sito web di crowd funding che si concentra su singole questioni e richieste di funzionalità in progetti Open Source utilizzando micropagamenti. Gli utenti, o "Sostenitori", possono impegnare denaro per risolvere un problema specifico, implementare nuove funzionalità o sviluppare un nuovo plugin o un nuovo tema. Gli sviluppatori di software open source, o "Bounty Hunters", possono quindi raccogliere e risolvere questi compiti per guadagnare denaro.

Ovviamente questo non permetterà ad uno sviluppatore di sostituire un lavoro a tempo pieno, ma piuttosto di "permettersi un caffè". Inoltre, ciò aiuta ad avvicinare utenti e sviluppatori, e mostra agli sviluppatori cosa vogliono gli utenti e quanto si preoccupino di certe cose. Infine, è ancora possibile donare denaro al progetto stesso, come modo semplice per dire "Grazie" e per supportare Pico.

Se vuoi incoraggiare gli sviluppatori a [risolvere un problema specifico][Problems] o implementare una funzionalità, puoi semplicemente [promettere una nuova ricompensa][Bountysource] o sostenere una funzionalità esistente.

Come sviluppatore puoi raccogliere una ricompensa semplicemente contribuendo a Pico (per favore fai riferimento alla sezione "Contributing" sopra). Non è necessario essere un Collaboratore ufficiale di Pico! Pico è un progetto Open Source, chiunque può aprire [richieste di pull][PullRequests] e richiedere bounties.

I Contributori Ufficiali Pico non rivendicheranno i premi per conto proprio, Pico non preleverà mai denaro da Bountysource. Tutto il denaro raccolto da Pico viene utilizzato per impegnare nuove taglie o per sostenere i progetti da cui Pico dipende.

[Composer]: https://getcomposer.org/
[LatestRelease]: https://github.com/picocms/Pico/releases/latest
[PicoGit]: https://github.com/picocms/Pico
[PicoThemeGit]: https://github.com/picocms/pico-theme
[PicoDeprecatedGit]: https://github.com/picocms/pico-deprecated
[PicoComposerGit]: https://github.com/picocms/pico-composer
[Packagist]: https://packagist.org/
[PicoPackagist]: https://packagist.org/packages/picocms/pico
[PicoThemePackagist]: https://packagist.org/packages/picocms/pico-theme
[PicoDeprecatedPackagist]: https://packagist.org/packages/picocms/pico-deprecated
[PicoComposerPackagist]: https://packagist.org/packages/picocms/pico-composer
[SemVer]: http://semver.org
[HelpUpgrade]: http://picocms.org/in-depth/upgrade/
[HelpUserDocs]: http://picocms.org/docs/
[HelpDevDocs]: http://picocms.org/development/
[Submit]: http://picocms.org/in-depth/submission_guidelines
[OfficialPlugins]: http://picocms.org/plugins/
[OfficialThemes]: http://picocms.org/themes/
[Wiki]: https://github.com/picocms/Pico/wiki
[WikiPlugins]: https://github.com/picocms/Pico/wiki/Pico-Plugins
[WikiThemes]: https://github.com/picocms/Pico/wiki/Pico-Themes
[Issues]: https://github.com/picocms/Pico/issues
[IssuesSearch]: https://github.com/picocms/Pico/search?type=Issues
[Freenode]: https://webchat.freenode.net/?channels=%23picocms
[FreenodeLogs]: http://picocms.org/irc-logs
[PullRequests]: https://github.com/picocms/Pico/pulls
[PullRequestsWebsite]: https://github.com/picocms/picocms.github.io/pulls
[ContributionGuidelines]: https://github.com/picocms/Pico/blob/master/CONTRIBUTING.md
[ContributionGuidelinesDCO]: https://github.com/picocms/Pico/blob/master/CONTRIBUTING.md#developer-certificate-of-origin
[EditInlineDocs]: https://github.com/picocms/Pico/edit/master/content-sample/index.md
[EditUserDocs]: https://github.com/picocms/picocms.github.io/tree/master/_docs
[EditDevDocs]: https://github.com/picocms/picocms.github.io/tree/master/_development
[Bountysource]: https://www.bountysource.com/teams/picocms
