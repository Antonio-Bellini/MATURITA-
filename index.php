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
?>
    <!-- menu di navigazione -->
    <main>
        <section class="header">
            <nav>
                <a href='index.php'>
                    <img 
                        src="image/logos/logo.png"
                        class="logo"
                        id="logoImg"
                        alt="logo associazione"
                    />
                </a>
                <div class="nav_links" id="navLinks">
                    <ul>
                        <li><a href="newsletter/newsletter.php"     class="btn">Newsletter   </a></li>
                        <li><a href="bacheca/bacheca.php"           class="btn">Bacheca       </a></li>
                        <li><a href="https://stripe.com/it"         class="btn" target="blank">Donazioni</a></li>
                        <li><a href="private/area_personale.php"    class="btn">Area Personale</a></li>
                    </ul>
                </div>
            </nav>            
        </section>
    </main>

    <!-- Sezione centrale della home con le foto -->
    <section class="body__main">
        <h1 class="title">Associazione ZeroTre</h1>
        <p class="paragraph">
            SIAMO GENITORI CHE CREDONO NEL MUTUO SOCCORSO PERCHÉ LO SCAMBIO DI EMOZIONI ED
            ESPERIENZE EVITA LA CHIUSURA NEL DOLORE E MIGLIORA LA QUALITÀ DI VITA FAMILIARE
            <br><br>
            <button id="btn_volunteer"><a href="volunteer_request.php">DIVENTA UN VOLONTARIO</a></button>
        </p>
        <div class="gallery">
            <img class="photo" src="image/content/image1.jpg" alt="immagine 1 della premiazione">
            <img class="photo" src="image/content/image2.jpg" alt="immagine 2 della premiazione">
            <img class="photo" src="image/content/image3.jpg" alt="immagine 3 della premiazione">
        </div>
    </section>

    <!-- Sezione con alcuni dati importanti dell'associazione -->
    <section class="association__info">
        <?php
            $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
            $query = "SELECT anni_associazione, volontari_attivi, famiglie_aiutate FROM registro_associazione";
            $result = dbQuery($connection, $query);
            
            if ($result) {
                while ($row = ($result->fetch_assoc())) {
                    $_SESSION["org_years"] = $row["anni_associazione"];
                    $_SESSION["org_volun"] = $row["volontari_attivi"];
                    $_SESSION["org_famil"] = $row["famiglie_aiutate"];
                }
            } else
                echo ERROR_DB;
        ?>
        <div id="yearsOfActivityContainer">
            <span id="yearsOfActivity" class="big-number"><?php echo isset($_SESSION["org_years"]) ? $_SESSION["org_years"] : "null" ?></span> Anni di attività
        </div>
        <div id="activeVolunteersContainer">
            <span id="activeVolunteers" class="big-number"><?php echo isset($_SESSION["org_volun"]) ? $_SESSION["org_volun"] : "null" ?></span> Volontari attivi
        </div>
        <div id="familiesHelpedContainer">
            <span id="familiesHelped" class="big-number"><?php echo isset($_SESSION["org_famil"]) ? $_SESSION["org_famil"] : "null" ?></span> Famiglie aiutate
        </div>

        <?php
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])
                echo "<button id='updateButton'>Aggiorna dati</button>";
        ?>
    </section>

    <!-- Sezione delle news dell'associazione -->
    <section class="association__news">
        <h2 class="news__title">News</h2>
        <div id="news_container" class="news__blocks">
            <?php
                $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                $query = "SELECT id, news, titolo, data, testo FROM news";
                $result = dbQuery($connection, $query);

                if (!$result->num_rows>0) 
                    echo "<h3>Nessuna news presente</h3>";

                if ($result) {
                    while ($row = ($result->fetch_assoc())) {
                        echo "
                            <div class='news__block'>
                                <img src='image/" . $row["news"] . "' alt='Immagine news'>
                                <div class='news__content'>
                                    <h3 class='news__title'>" . $row["titolo"] . "</h3>
                                    <p class='news__date'>" . date("d-m-Y", strtotime($row["data"])) . "</p>
                                    <p class='news__text'>" . $row["testo"] . "</p>
                                </div>";
                                if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])
                                    echo "<button class='del_content_button' data-operation='delete' data-profile='home_news' data-user=" . $row["id"] . ">Elimina contenuto</button>";
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

    <!-- Modale per l'inserimento dei nuovi dati dell'associazione -->
    <div id="newData_modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <br>
            
            <form action="private/update_home.php" method="POST">
                <input type="hidden" name="type" value="home_info">

                <label for="newYears">Anni di attività:</label>
                <input type="number" id="newYears" class="modal__input" name="newYears">
                
                <label for="newVolunteers">Volontari attivi:</label>
                <input type="number" id="newVolunteers" class="modal__input" name="newVolunteers">
                
                <label for="newFamilies">Famiglie aiutate:</label>
                <input type="number" id="newFamilies" class="modal__input" name="newFamilies">

                <input type="submit" id="saveButton" class="btn" value="SALVA">
            </form>
        </div>
    </div>

    <!-- modale per inserire un nuovo contenuto news -->
    <div id="newNews_modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <br>

            <h2>Inserimento di una news</h2>
            <br>
            
            <form action="private/update_home.php" enctype="multipart/form-data" method="POST">
                <input type="hidden" name="type" value="home_news">

                <label for="image">Seleziona la foto</label><br>
                <input type="file" id="image" class="modal__input" name="news__image" accept="image/*" required>
                
                <br><label for="title">Inserisci il titolo della news</label>
                <input type="text" id="title" class="modal__input" name="news__title" maxlength="255" required>
                
                <label for="date">Inserisci la data di inserimento della news</label>
                <input type="date" id="date" class="modal__input" name="news__date" required>

                <label for="text">Inserisci il testo</label>
                <textarea name="news__text" id="text" cols='30' rows='10' placeholder="Inserisci il testo della news" class="modal__input" maxlength="255" required></textarea> 

                <input type="submit" id="saveButton" class="btn" value="SALVA">
            </form>
        </div>
    </div>

    <?php show_footer() ?>
</body>
</html>