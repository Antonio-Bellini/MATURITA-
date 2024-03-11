<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    $operation = null;

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    switch ($operation) {
        case "read_med":
            showMenu();
            
            echo "<label>Di quale assistito vuoi leggere l'anamnesi?</label><br>";
            echo "<select name='assisted' id='assistedOption'>";
                $query = "SELECT id, nome, cognome, anamnesi, note
                            FROM assistiti a";
                $result = dbQuery($connection, $query);

                if ($result) {
                    while ($row = ($result->fetch_assoc()))
                        echo "<option id='assisted' name='assisted_" . $row["id"] . "'>" . $row["nome"] . " " . $row["cognome"] . "</option>";
                }
            echo "</select>";
        break;

        case "mng_adm":
            showMenu();
            
            echo "Ecco una tabella di tutti i dati degli admin presenti<br><br>";
            $query = "SELECT nome, cognome, username, email, telefono_fisso, telefono_mobile, note, numero_accessi
                    FROM utenti u
                    WHERE u.id_profilo = 2";
            $result = dbQuery($connection, $query);

            if ($result) {
                createTable($result);
            }
        break;

        case "LOGOUT":
            if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
                $_SESSION["is_logged"] = false;
                $_SESSION["username"] = null;
                $_SESSION["user_id"] = null;
                if (session_destroy()) {
                    showMenu();
                    echo "Disconnessione avvenuta con successo"; 
                }
            } else
                header("Location: loginPage.php");
        break;
    }
?>