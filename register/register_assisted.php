<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../script/script.js"></script>
    <title>Associazione ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "../util/cookie.php";
    importActualStyle();
?>
    <?php
        include "../util/command.php";
        include "../util/connection.php";
        $connection = connectToDatabase(DB_NAME);

        session_start();
        if (!isset($_SESSION["is_parent"]))
            $_SESSION["is_parent"] = false;
        
        if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                echo "  <button><a href='../index.php'>HOME</a></button>
                        <button><a href='../newsletter.php'>NEWSLETTER</a></button>
                        <button><a href='../bacheca.php'>BACHECA</a></button>
                        <button><a href='../private/area_personale.php'>AREA PERSONALE</a></button>
                        <button><a href='../private/crud.php?operation=LOGOUT'>LOGOUT</a></button><br><br>";

                echo "<h1>Pagina di registrazione di un assistito</h1>";
                echo "<br>Chi é il referente?";
                $query = "SELECT id, nome, cognome FROM utenti";
                $result = dbQuery($connection, $query);

                if ($result) {
                    echo "<main>
                            <form action='register.php' name='form_assisted' id='form_register__assisted' method='POST' enctype='multipart/form-data'>
                                <input type='hidden' name='form_assisted'>

                                <select name='parent'>";
                                    while ($row = ($result->fetch_assoc()))
                                         echo "<option value='" . $row["id"] . "'>" . $row["nome"] . " " . $row["cognome"] . "</option>";
                                echo "</select><br>

                                <label for='name'>Inserisci il nome</label>
                                <input type='text' name='name' id='name' required> <br>

                                <label for='surname'>Inserisci il cognome</label>
                                <input type='text' name='surname' id='surname' required> <br>

                                <label for='med'>Inserisci il file dell'anamnesi</label>
                                <input type='file' name='med' id='med' accept='.pdf' enctype='multipart/form-data' required> <br>

                                <label for='notes'>Inserisci qualche nota aggiuntiva</label> <br>
                                <textarea name='notes' id='notes' cols='30' rows='10' placeholder='Altre info utili'></textarea><br><br>

                                <input type='submit' value='REGISTRA'><br><br>
                            </form>
                        </main>";
                }
            } else 
            header("Location: ../private/loginPage.php");
        } else 
            header("Location: ../private/loginPage.php");
    ?>
</body>
</html>