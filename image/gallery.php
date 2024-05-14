<!DOCTYPE html>
<html lang="en">
<?php
    include "../util/constants.php";
    include "../util/cookie.php";
    include "../util/command.php";
    include "../util/connection.php";

    session_start();

    echo "
        <head>
            <meta charset='UTF-8'>
            <meta http-equiv='X-UA-Compatible' content='IE=edge'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <script src='https://kit.fontawesome.com/a730223cdf.js' crossorigin='anonymous'></script>
            <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo    WEBALL;
    echo "  <script src='../script/script.js'></script>
            <link rel='stylesheet' href='../style/style.css'>
            <link rel='icon' href='image/logos/logo.png' type='x-icon'>
            <title>Associazione Zero Tre</title>
        </head>";

        importActualStyle();
        check_operation();

        nav_menu();

        
?>
<body>
    <!-- Sezione delle immagini dei ragazzi -->
    <section class="association__news">
        <h2 class="news__title">Immagini dei ragazzi</h2>
        <div id="news_container" class="news__blocks">
            <?php
                $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                $query = "SELECT id, path FROM images";
                $result = dbQuery($connection, $query);

                if (!$result->num_rows>0) 
                    echo "<h3>Nessuna immagine presente</h3>";

                if ($result) {
                    while ($row = ($result->fetch_assoc())) {
                        echo "
                            <div class='news__block'>
                                <img src='" . $row["path"] . "' alt='Immagine'>";
                                if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])
                                    echo "<button class='del_content_button' data-operation='delete' data-profile='home_images' data-user=" . $row["id"] . ">Elimina contenuto</button>";
                        echo "</div>";
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
            
            <form action="../private/update_home.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="type" value="home_images">

                <label for="image">Seleziona la foto</label><br>
                <input type="file" id="image" class="modal__input" name="ragazzi__image" accept="image/*" required>
                

                <input type="submit" id="saveButton" class="btn" value="SALVA">
            </form>
        </div>
    </div>

    <?php 
        show_footer2();
    ?>
</body>
</html>