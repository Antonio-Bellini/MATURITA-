<!DOCTYPE html>
<html lang="en">
<?php
    include "../util/constants.php";
    include "../util/command.php";

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
            <link rel='icon' href='../image/logos/logo.png' type='x-icon'>
            <title>Associazione Zero Tre</title>
        </head>";

        session_start();

    nav_menu();

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        echo "
        <br>
        <section id='form'>
            <h2>Pagina per il caricamento delle anamnesi</h2>
            
            <br><br><br><br>

            <!-- form per caricamento del file anamnesi per gli assistiti -->
            <section id='form_assisted__medical'>
                <form action='upload.php' method='POST' enctype='multipart/form-data' name='medical_assisted'>
                    <input type='hidden' name='user_type' value='assisted'>

                    <label for='assisted'>L'assistito per cui stai caricando l'anamnesi é</label>
                    <select name='assisted' id='assisted'>";
                        $userId = $_SESSION["user"]; 
                        $connection = connectToDatabase(DB_HOST, DB_TERAPIST, TERAPIST_PW, DB_NAME);
                        $query = "SELECT id, nome, cognome FROM assistiti WHERE id=$userId";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            while ($row = ($result->fetch_assoc()))
                                echo "<option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
                        } else 
                            echo ERROR_DB;
        echo "      </select>

                    <label for='medical'>Seleziona il file che vuoi caricare</label>
                    <input type='file' name='medical' accept='.pdf' required>

                    <label for='notes'>Inserisci qualche nota aggiuntiva sul file</label>
                    <textarea name='notes' id='notes' cols='30' rows='10' placeholder='Info utili sul file'></textarea>

                    <input type='submit' value='CARICA FILE'></input>
                </form>
            </section>
        </section>";
    } else 
        header("Location: ../index.php");
?>
</body>
</html>