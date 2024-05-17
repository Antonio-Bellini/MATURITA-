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
            <style>

            </style>
        </head>";

        importActualStyle();
        check_operation();

        nav_menu2();
?>

<body>
    <!-- Sezione delle immagini dei ragazzi -->
    <section class="association__gallery">
        <h1 class="about__title">Cosa offriamo</h1>
        
        <div id="gallery_container" class="gallery__blocks">
            <?php
                $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                $query = "SELECT id, path FROM images";
                $result = dbQuery($connection, $query);

                if (!$result->num_rows > 0) 
                    echo "<h3>Nessuna immagine presente</h3>";

                if ($result) {
                    while ($row = $result->fetch_assoc()) {
                        if (strpos($row["path"], "offer") === 0) {
                            echo "
                                <div class='gallery__block'>
                                    <img src='image/" . $row["path"] . "' alt='Immagine'>
                                    <div class='overlay'>
                                        <button><a href='image/" . $row["path"] . "' target='_blank'>Apri in nuova scheda</a></button>
                                    </div>";
                                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])
                                        echo "<button class='delete_content_button' data-operation='delete' data-user='" . $row["id"] . "' data-profile='home_images'>Elimina contenuto</button>";
                            echo "</div>";
                        }
                    }
                } else 
                    echo ERROR_DB;
            ?>
        </div>

        <?php
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])
                echo "<button id='add_content_button'>Aggiungi contenuti</button>";
        ?>
    </section>

    <!-- modale per inserire una nuova pagina -->
    <div id="newNews_modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <br>

            <h2>Inserimento di una nuova immagine</h2>
            <br>
            
            <form action="private/update_home.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="type" value="home_offer">

                <label for="image">Seleziona la foto</label><br>
                <input type="file" id="image" class="modal__input" name="offer__image" accept="image/*" required>
                
                <input type="submit" id="saveButton" class="btn" value="SALVA">
            </form>
        </div>
    </div>

    <?php show_footer(); ?>
</body>
</html>
