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

    <section class="body__main">
        <h1 class="title">Associazione ZeroTre</h1>
        <p class="paragraph">
            SIAMO GENITORI CHE CREDONO NEL MUTUO SOCCORSO PERCHÉ LO SCAMBIO DI EMOZIONI ED
            ESPERIENZE EVITA LA CHIUSURA NEL DOLORE E MIGLIORA LA QUALITÀ DI VITA FAMILIARE
            <br><br>
            <button><a href="volunteer_request.php">DIVENTA UN VOLONTARIO</a></button>
        </p>
        <div class="gallery">
            <img class="photo" src="image/content/image1.jpg" alt="immagine 1 della premiazione">
            <img class="photo" src="image/content/image2.jpg" alt="immagine 2 della premiazione">
            <img class="photo" src="image/content/image3.jpg" alt="immagine 3 della premiazione">
        </div>
    </section>

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

    <!-- Modale per l'inserimento dei nuovi dati -->
    <div id="newData_modal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <br>
            
            <form action="private/update_home.php" method="POST">
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

    <?php show_footer() ?>
</body>
</html>