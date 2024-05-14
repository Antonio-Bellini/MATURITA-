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
            <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css'>
            <script src='https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js'></script>
            <title>Associazione Zero Tre</title>
        </head>";

        importActualStyle();
        check_operation();

        nav_menu2();
?>

<body>
    <h1 class="offer-h1">Cosa Offre la Nostra Associazione</h1>
    <h2 class="offer-h2">Ecco i nostri Listini:</h2>

    <div class="image-gallery">
        <div class="scrollable-images">
            <?php 
                // Directory contenente le immagini
                $imageDirectory = 'image/offer';

                // Ottenere elenco di file nella directory
                $files = glob($imageDirectory . '/*');

                // Mostrare le immagini
                foreach ($files as $file) {
                    if (is_file($file)) {
                        echo "<a href='$file' data-lightbox='image-gallery'><img src='$file' alt='offer_imgs'></a>";
                    }
                }
            ?>
        </div>
    </div>
    <br><br><br>
    <?php 
    show_footer2();
    ?>
</body>
</html>
