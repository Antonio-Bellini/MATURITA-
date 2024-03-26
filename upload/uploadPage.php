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
                            <li><a href='../newsletter.php'             class='btn'>Newsletter   </a></li>
                            <li><a href='../bacheca.php'                class='btn'>Bacheca       </a></li>
                            <li><a href='https://stripe.com/it'         class='btn'>Donazioni     </a></li>
                            <li><a href='../private/area_personale.php'    class='btn'>Area Personale</a></li>
                        </ul>
                    </div>
                </nav>            
            </section>
        </main>";
?>
    <h4><br><br>PAGINA CARICAMENTO LIBERATORIE <br> Assicurati di caricare solo il file PDF firmato <br><br></h4>
    <label for="choice">Per chi vuoi caricare la liberatoria?</label><br>
    <select name="choice" id="choice">
        <option value="1">Assistito</option>
        <option value="2">Volontario</option>
    </select>

    <br><br>

    <!-- form per caricamento del file per gli assistiti -->
    <section id="form_assisted">
        <form action="upload.php" method="POST" enctype="multipart/form-data" name="release_assisted">
            <input type="hidden" name="user_type" value="assisted">

            <label for="assisted">Per quale assistito vuoi caricare la liberatoria?</label><br>
            <select name="assisted" id="assisted">
            <?php
                $connection = connectToDatabase(DB_HOST, USER_ADMIN, ADMIN_PW, DB_NAME);
                $query = "SELECT id, nome, cognome FROM assistiti";
                $result = dbQuery($connection, $query);

                if ($result) {
                    while ($row = ($result->fetch_assoc()))
                        echo "<option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
                } else 
                    echo "<option>Nessun risultato trovato</option>";
            ?>
            </select><br><br>
            <input type="file" name="release" accept=".pdf" enctype="multipart/form-data" required><br><br>

            <label for="notes">Inserisci qualche nota aggiuntiva</label> <br>
            <textarea name="notes" id="notes" cols="30" rows="10" placeholder="info utili sul file"></textarea> <br><br><br>

            <button type="submit">Carica File</button>
        </form>
    </section>

    <!-- form per caricamento del file per i volontari -->
    <section id="form_volunteer">
        <form action="upload.php" method="POST" enctype="multipart/form-data" name="release_volunteer">
            <input type="hidden" name="user_type" value="volunteer">

            <label for="assisted">Per quale volontario vuoi caricare la liberatoria?</label><br>
            <select name="volunteer" id="volunteer">
            <?php
                $connection = connectToDatabase(DB_HOST, USER_ADMIN, ADMIN_PW, DB_NAME);
                $query = "SELECT id, nome, cognome FROM volontari";
                $result = dbQuery($connection, $query);

                if ($result) {
                    while ($row = ($result->fetch_assoc()))
                        echo "<option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
                } else 
                    echo "<option>Nessun risultato trovato</option>";
            ?>
            </select><br><br>
            <input type="file" name="release" accept=".pdf" enctype="multipart/form-data" required><br><br>

            <label for="notes">Inserisci qualche nota aggiuntiva</label> <br>
            <textarea name="notes" id="notes" cols="30" rows="10" placeholder="info utili sul file"></textarea> <br><br><br>

            <button type="submit">Carica File</button>
        </form>
    </section>
</body>
</html>