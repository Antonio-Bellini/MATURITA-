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
        <h4>Assicurati di caricare solo file PDF firmati</h4>
        <form action="util/upload.php" method="POST" enctype="multipart/form-data">
            <label for="assisted">Per quale assistito vuoi caricare la liberatoria?</label><br>
            <select name="assisted" id="assisted">
            <?php
                $connection = connectToDatabase(DB_NAME);
                $result = getUserAssisted($connection, $_SESSION["user_id"]);

                if ($result) {
                    while ($row = ($result->fetch_assoc()))
                        echo "<option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
                } else 
                    echo "<option>Nessun risultato trovato</option>";
            ?>
            </select><br><br>
            <input type="file" name="file" accept=".pdf" required><br><br>
            <button type="submit">Carica File</button>
        </form>
    </main>
</body>
</html>
