<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo WEBALL;
    echo "<script src='script/script.js'></script>";
    echo "<script type='text/javascript'src='https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js'></script>";
    echo "<script type='text/javascript'> emailjs.init('cx_DHiqEbFqDomUtu') </script>";
    echo "<link rel='stylesheet' href='style/style.css'>";
    echo "<title>Associazione Zero Tre</title>";
    importActualStyle();
    session_start();

    nav_menu2();

    echo "<br>
        <section id='form'>
            <h2>Vuoi diventare un volontario dell'associazione? <br>Compila il form e ti ricontatteremo</h2>
            
            <form name='volunteer_request' action='private/send_email.php' id='volunteer_request' method='POST'>
                <br><br>

                <div class='div__label'>
                    <label for='name'>Inserisci il tuo nome *</label>
                    <label for='surname'>Inserisci il tuo cognome *</label>
                </div>

                <div class='div__input'>
                    <input type='text' name='name' id='name' required>
                    &nbsp;&nbsp;
                    <input type='text' name='surname' id='surname' required>
                </div>

                <label for='email'>Inserisci la tua email *</label>
                <input type='email' name='email' id='email'>

                <div class='div__label'>
                    <label for='tf'>Inserisci il numero di telefono fisso</label>
                    <label for='tm'>Inserisci il numero di telefono mobile *</label>
                </div>
                <div class='div__input'>
                    <input type='number' name='tf' id='tf'>
                    &nbsp;&nbsp;
                    <input type='number' name='tm' id='tm' required>
                </div>

                <label for='info'>Parlaci un po' di te</label>
                <textarea name='info' id='info' cols='30' rows='10' placeholder='Dicci qualcosa su di te'></textarea>

                <input type='submit' value='INVIA' id='send_form'>
            </form>
        </section>";

    // js per invio dell'email tramite utilizzo di WS fornito da EmailJS
    echo "  <script>
                const btn = document.getElementById('send_form');

                document.getElementById('volunteer_request').addEventListener('submit', function (e) {
                    e.preventDefault();

                    btn.value = 'Invio...';

                    const serviceID = 'default_service';
                    const templateID = 'template_fuonb84';

                    emailjs.sendForm(serviceID, templateID, this)
                        .then(() => {
                            btn.value = 'Inviato';
                            alert('Email inviata correttamente, ti ricontatteremo presto!');
                        }, (err) => {
                            btn.value = 'Errore';
                            alert(JSON.stringify(err));
                        });
                });
            </script>";

    show_footer();
?>