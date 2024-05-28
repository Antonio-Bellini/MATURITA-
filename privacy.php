<!DOCTYPE html>
<html lang="en">
<?php
    include "util/constants.php";
    include "util/command.php";
    include "util/connection.php";

    session_start();

    echo "
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <script src='https://kit.fontawesome.com/a730223cdf.js' crossorigin='anonymous'></script>
            <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo    WEBALL;
    echo "  <script src='script/script.js'></script>
            <link rel='stylesheet' href='style/style.css'>
            <link rel='icon' href='image/logos/logo.png' type='x-icon'>
            <title>Associazione Zero Tre</title>
        </head>";

        check_operation();

        nav_menu2();
?>

<body>
    <br><br>
    <h1 class='about__title'>Privacy & Policy</h1>
    <br>
    <h2 class="privacy-subtitle">ZEROTRE ODV<br>Associazione legalmente riconosciuta<br>Iscritta al Registro Regionale del Volontariato</h2>
    
    <div class="privacy-content">
        <h3 class="privacy-heading">Oggetto: Informativa ai sensi dell’art. 13 del Regolamento UE n. 2016/679</h3>
        <p>Ai sensi dell’art. del Regolamento UE n. 2016/679 (di seguito “GDPR 2016/679”), recante disposizioni a tutela delle persone e di altri soggetti rispetto al trattamento dei dati personali, desideriamo informarLa che i dati personali da Lei forniti formeranno oggetto di trattamento nel rispetto della normativa sopra richiamata e degli obblighi di riservatezza cui è tenuta l’Associazione Zerotre odv.</p>

        <h3 class="privacy-heading">Titolare del trattamento</h3>
        <p>Il Titolare del trattamento è l’Associazione / il Presidente dell’Associazione VALERIA RUBIA.., sita in Torino – Corso Unione Sovietica 220/d.</p>

        <h3 class="privacy-heading">Finalità del trattamento</h3>
        <p>I dati personali da Lei forniti sono necessari per lo svolgimento dell’attività propria dell’Associazione (da dettagliare in caso di finalità diversa o in caso di trasmissione/ comunicazione dati a soggetti terzi o diffusione).</p>

        <h3 class="privacy-heading">Modalità di trattamento e conservazione</h3>
        <p>Il trattamento sarà svolto in forma automatizzata e/o manuale, nel rispetto di quanto previsto dall’art. 32 del GDPR 2016/679 in materia di misure di sicurezza, ad opera di soggetti appositamente incaricati e in ottemperanza a quanto previsto dall’art. 29 GDPR 2016/ 679.
        Le segnaliamo che, nel rispetto dei principi di liceità, limitazione delle finalità e minimizzazione dei dati, ai sensi dell’art. 5 GDPR 2016/679, previo il Suo consenso libero ed esplicito espresso in calce alla presente informativa, i Suoi dati personali saranno conservati per il periodo di tempo necessario per il conseguimento delle finalità per le quali sono raccolti e trattati.</p>

        <h3 class="privacy-heading">Ambito di comunicazione e diffusione</h3>
        <p>Informiamo inoltre che i dati raccolti non saranno mai diffusi e non saranno oggetto di comunicazione senza Suo esplicito consenso.</p>

        <h3 class="privacy-heading">Trasferimento dei dati personali</h3>
        <p>I suoi dati non saranno trasferiti né in Stati membri dell’Unione Europea né in Paesi terzi non appartenenti all’Unione Europea.</p>

        <h3 class="privacy-heading">Categorie particolari di dati personali</h3>
        <p>Ai sensi degli articoli 9 e 10 del Regolamento UE n. 2016/679, Lei potrebbe conferire all’Associazione dati qualificabili come “categorie particolari di dati personali” e cioè quei dati che rivelano “l'origine razziale o etnica, le opinioni politiche, le convinzioni religiose o filosofiche, o l'appartenenza sindacale, nonché dati genetici, dati biometrici intesi a identificare in modo univoco una persona fisica, dati relativi alla salute o alla vita sessuale o all’orientamento sessuale della persona”. Tali categorie di dati potranno essere trattate solo previo Suo libero ed esplicito consenso, manifestato in forma scritta in calce alla presente informativa.</p>

        <h3 class="privacy-heading">Diritti dell’interessato</h3>
        <p>In ogni momento, Lei potrà esercitare, ai sensi degli articoli dal 15 al 22 del Regolamento UE n. 2016/679, il diritto di:</p>
        <ul class="privacy-list">
            <li>chiedere la conferma dell’esistenza o meno di propri dati personali;</li>
            <li>ottenere le indicazioni circa le finalità del trattamento, le categorie dei dati personali, i destinatari o le categorie di destinatari a cui i dati personali sono stati o saranno comunicati e, quando possibile, il periodo di conservazione;</li>
            <li>ottenere la rettifica e la cancellazione dei dati;</li>
            <li>ottenere la limitazione del trattamento;</li>
            <li>ottenere la portabilità dei dati, ossia riceverli da un titolare del trattamento, in un formato strutturato, di uso comune e leggibile da dispositivo automatico, e trasmetterli ad un altro titolare del trattamento senza impedimenti;</li>
            <li>opporsi al trattamento in qualsiasi momento ed anche nel caso di trattamento per finalità di marketing diretto;</li>
            <li>opporsi ad un processo decisionale automatizzato relativo alle persone ﬁsiche, compresa la profilazione;</li>
            <li>chiedere al titolare del trattamento l’accesso ai dati personali e la rettifica o la cancellazione degli stessi o la limitazione del trattamento che lo riguardano o di opporsi al loro trattamento, oltre al diritto alla portabilità dei dati;</li>
            <li>revocare il consenso in qualsiasi momento senza pregiudicare la liceità del trattamento basata sul consenso prestato prima della revoca;</li>
            <li>proporre reclamo a un’autorità di controllo.</li>
        </ul>
        <p>Può esercitare i Suoi diritti con richiesta scritta inviata a Zerotre odv Corso Unione Sovietica 220/d, all'indirizzo postale della sede legale o all’indirizzo mail Zerotre.odv@gmail.com.</p>
    </div>

    <?php 
    show_footer2();
    ?>
</body>
</html>
