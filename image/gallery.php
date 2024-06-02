<!DOCTYPE html>
<html lang="en">
<?php
    include "../util/constants.php";
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

        check_operation();

        nav_menu();
?>
<body>
    <!-- Sezione delle immagini dei ragazzi -->
    <section class="association__gallery">
        <h1 class="about__title">Immagini dei ragazzi</h1>
        
        <div id="gallery_container" class="gallery__blocks">
            <?php
                $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                $query = "SELECT i.id, i.path, s.titolo 
                          FROM immagini i
                          INNER JOIN sezioni_foto s ON i.id_titolo = s.id";
                $result = dbQuery($connection, $query);
                
                if (!$result->num_rows > 0) {
                    echo "<h3>Nessuna immagine presente</h3>";
                } else {
                    $images_by_category = [];
                
                    while ($row = ($result->fetch_assoc())) {
                        $category = $row['titolo'];
                        if (!isset($images_by_category[$category]))
                            $images_by_category[$category] = [];

                        $images_by_category[$category][] = $row;
                    }
                
                    // genero un container per ogni sezione
                    foreach ($images_by_category as $category => $images) {
                        echo "<div class='category-block'>";
                        echo "  <h3>" . htmlspecialchars($category) . "</h3>";
                
                        foreach ($images as $image) {
                            echo "<div class='gallery__block'>
                                    <img src='" . htmlspecialchars($image['path']) . "' alt='Immagine'>
                                    <div class='overlay'>
                                        <button><a href='" . htmlspecialchars($image['path']) . "' target='_blank'>Apri in nuova scheda</a></button>
                                    </div>";
                            if (isset($_SESSION['is_admin']) && $_SESSION['is_admin']) {
                                echo "<button class='delete_content_button' data-operation='delete' data-user='" . htmlspecialchars($image['id']) . "' data-profile='home_images'>Elimina contenuto</button>";
                            }
                            echo "</div>";
                        }
                
                        echo "</div>";
                    }
                }   
            ?>
        </div>

        <?php
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                echo "<button class='add_content_button' id='add_content_button'>Aggiungi contenuti</button><br>";
                echo "<button class='add_content_button' id='add_title_button'>Aggiungi titolo sezione</button>";
                echo "<button class='del_content_button3' id='del_content_button'>Elimina titolo sezione</button>";
            }
        ?>
    </section>

    <!-- modale per inserire una nuova pagina -->
    <div id="newNews_modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <br>

            <h2>Inserimento di una nuova immagine</h2>
            <br>
            
            <form action="../private/update.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="type" value="gallery_img">

                <label for="image">Seleziona la foto</label><br>
                <input type="file" id="image" class="modal__input" name="ragazzi__image" accept="image/*" required>

                <label for="title">In quale categoria vuoi aggiungere la foto?</label><br>
                <select name="title">
                    <?php
                        $query = "SELECT id, titolo FROM sezioni_foto";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            while ($row = ($result->fetch_assoc()))
                                echo "<option value='" . $row["id"] . "'>" . $row["titolo"] . "</option>";
                        } else
                            echo ERROR_DB;
                    ?>
                </select>

                <input type="submit" id="saveButton" class="btn" value="SALVA">
            </form>
        </div>
    </div>

    <!-- modale per inserire una nuova sezione -->
    <div id="newTitle_modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <br>

            <h2>Inserimento di una nuova sezione</h2>
            <br>

            <form action="../private/update.php" method="POST">
                <input type="hidden" name="type" value="gallery_section">

                <label for="title">Seleziona il titolo della sezione</label><br>
                <input type="text" id="title" class="modal__input" name="section_title" required>

                <input type="submit" id="saveButton" class="btn" value="SALVA">
            </form>
        </div>
    </div>

    <!-- modale per eliminare una sezione -->
    <div id="delTitle_modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <br>

            <h2>Quale sezione vuoi cancellare?</h2>
            <br>

            <form action="../private/crud.php" method="POST">
                <input type="hidden" name="profile" value="home_imgSection">
                <input type="hidden" name="operation" value="delete">

                <label for="title">Quale sezione vuoi cancellare?</label><br>
                <label for="title">ATTENZIONE! Non puoi eliminare una sezione se ci sono delle foto al suo interno</label><br>
                <select name="section">
                    <?php
                        $query = "SELECT id, titolo FROM sezioni_foto";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            while ($row = ($result->fetch_assoc()))
                                echo "<option value='" . $row["id"] . "'>" . $row["titolo"] . "</option>";
                        } else 
                            echo ERROR_DB;
                    ?>
                </select>

                <input type="submit" id="saveButton" class="btn" value="ELIMINA">
            </form>
        </div>
    </div>

    <?php show_footer2(); ?>
</body>
</html>