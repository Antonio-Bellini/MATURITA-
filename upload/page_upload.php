<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../script/script.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <title>Associazione ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "../util/cookie.php";
    include "../util/command.php";
    include "../util/connection.php";
    importActualStyle();
    session_start();

    // menu di navigazione
    echo "<main>
            <section class='header'>
                <nav>
                    <a href='../index.php'>
                        <img 
                            src='../image/logos/logo.png'
                            class='logo'
                            id='logoImg'
                            alt='logo associazione'
                        />
                    </a>
                    <div class='nav_links' id='navLinks'>
                        <ul>
                            <li><a href='../newsletter/newsletter.php'  class='btn'>Newsletter   </a></li>
                            <li><a href='../bacheca/bacheca.php'        class='btn'>Bacheca       </a></li>
                            <li><a href='https://stripe.com/it'         class='btn' target='blank'>Donazioni</a></li>
                            <li><a href='../private/area_personale.php' class='btn'>Area Personale</a></li>
                        </ul>
                    </div>
                </nav>            
            </section>
        </main>";
?>
    <br>
    <section id="form">
        <h2>Pagina per il caricamento delle liberatorie</h2>
        <h3>Assicurati di caricare solo il file PDF firmato</h3><br><br>
        <label for="choice">Per chi vuoi caricare la liberatoria?</label>
        <select name="choice" id="choice">
            <option value="1">Assistito</option>
            <option value="2">Volontario</option>
        </select>

        <br><br>

        <!-- form per caricamento del file per gli assistiti -->
        <section id="form_assisted">
            <form action="upload.php" method="POST" enctype="multipart/form-data" name="release_assisted">
                <input type="hidden" name="user_type" value="assisted">

                <label for="assisted">Per quale assistito vuoi caricare la liberatoria?</label>
                <select name="assisted" id="assisted">
                <?php
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $query = "SELECT id, nome, cognome FROM assistiti";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        while ($row = ($result->fetch_assoc()))
                            echo "<option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
                    } else 
                        echo "<option>Nessun risultato trovato</option>";
                ?>
                </select>

                <label for="release">Seleziona il file che vuoi caricare</label>
                <input type="file" name="release" accept=".pdf" enctype="multipart/form-data" required>

                <label for="notes">Inserisci qualche nota aggiuntiva sul file</label>
                <textarea name="notes" id="notes" cols="30" rows="10" placeholder="Info utili sul file"></textarea>

                <input type="submit" value="CARICA FILE"></input>
            </form>
        </section>

        <!-- form per caricamento del file per i volontari -->
        <section id="form_volunteer">
            <form action="upload.php" method="POST" enctype="multipart/form-data" name="release_volunteer">
                <input type="hidden" name="user_type" value="volunteer">

                <label for="assisted">Per quale volontario vuoi caricare la liberatoria?</label>
                <select name="volunteer" id="volunteer">
                <?php
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $query = "SELECT id, nome, cognome FROM volontari";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        while ($row = ($result->fetch_assoc()))
                            echo "<option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
                    } else 
                        echo "<option>Nessun risultato trovato</option>";
                ?>
                </select>
                <label for="release">Seleziona il file che vuoi caricare</label>
                <input type="file" name="release" accept=".pdf" enctype="multipart/form-data" required>

                <label for="notes">Inserisci qualche nota aggiuntiva sul file</label>
                <textarea name="notes" id="notes" cols="30" rows="10" placeholder="info utili sul file"></textarea>

                <input type="submit" value="CARICA FILE"></button>
            </form>
        </section>
    </section>
    
    <?php show_footer(); ?>
</body>
</html>