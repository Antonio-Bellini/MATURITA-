<!DOCTYPE html>
<html lang="en">
<?php
    include "util/constants.php";
    include "util/cookie.php";
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

        importActualStyle();
        check_operation();

        nav_menu2();
?>

<body>
    <div class="about__container">
        <h1 class="about__title">Perché ci siamo?</h1>

        <div class="about__container_sub">
            <div class="about__container_sub__other">
                <h2>
                    Perché crediamo fermamente che anche nelle <span class="highlight">sfide più difficili</span>, 
                    esista sempre una luce da seguire.
                </h2>
            </div>
             
            <div class="about__container_sub__other">
                <h2>
                    Perché ci impegniamo a essere un <span class="highlight">porto sicuro</span> per chi ha bisogno 
                    di condividere le proprie emozioni, senza giudizi.
                </h2>
            </div>
            
            <div class="about__container_sub__other">
                <h2>
                    Perché vogliamo <span class="highlight">ispirare</span> speranza e coraggio, 
                    dimostrando che nessuno è mai solo nella propria battaglia.
                </h2>
            </div>
            
            <div class="about__container_sub__other">
                <h2>
                    Perché crediamo che ogni passo avanti , anche il più piccolo, meriti di
                    essere celebrato con <span class="highlight">gioia e gratitudine</span>.
                </h2>
            </div>
        </div>
    </div>

    <?php show_footer(); ?>
</body>
</html>