<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    // inizalizzo la sessione per salvare il login dell'utente
    if (!isset($_SESSION["is_logged"]))
        $_SESSION["is_logged"] = false;

    $email = $_POST["email"];
    $password = $_POST["password"];

    // eseguo la query sul db per controllare se username e password sono corretti
    if (!$_SESSION['is_logged']) {
        try {
            $query = "SELECT password
                    FROM utenti
                    WHERE email = '$email';";
            $result = dbQuery($connection, $query);

            if ($result) {
                $password_enc = HASH("sha256", $password);
                
                while ($row = ($result->fetch_assoc())) {
                    if ($row["password"] === $password_enc) {
                        $_SESSION["is_logged"] = true;

                        welcome($email);
                    }
                }
            } else {
                echo "Si é verificato un errore nel recuperare i dati dal database, riprova piu tardi";
            }
        } catch(Exception) {
            echo "Problema interno, riprova piú tardi";
        }
    } else {
        welcome($email);
    }
?>