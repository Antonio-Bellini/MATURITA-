<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="script/script.js"></script>
    <title>Associazione ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "util/cookie.php";
    include "util/command.php";
    include "util/connection.php";
    importActualStyle();
    session_start();
?>
    <main>
        <h1>Pagina di caricamento delle liberatorie</h1>
        <h4>Assicurati di caricare solo il file PDF firmato</h4>
        <form action="util/upload.php" method="POST" enctype="multipart/form-data">
            <label for="assisted">Per quale assistito vuoi caricare la liberatoria?</label><br>
            <select name="assisted" id="assisted">
            <?php
                $connection = connectToDatabase(DB_NAME);
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
    </main>
</body>
</html>
