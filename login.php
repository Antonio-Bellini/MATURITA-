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

    #region VALIDAZIONE dei DATI per il LOGIN    
    $email = $_POST["email"];
    $password = $_POST["password"];

    // eseguo la query sul db per controllare se username e password sono corretti
    if (!$_SESSION['is_logged']) {
        $query = "SELECT password
                    FROM username_password
                    WHERE username = '$email';";
        $result = dbQuery($connection, $query);

        if ($result) {
            $password_enc = HASH("sha256", $password);
            
            while ($row = ($result->fetch_assoc())) {
                if ($row["password"] === $password_enc) {
                    $_SESSION["is_logged"] = true;
    #endregion
    #region BENVENUTO all'APPLICAZIONE e AREA PERSONALE
                    welcome($email);
                }
            }
        } else {
            echo "Si é verificato un errore, riprova piu tardi";
        }
    } else {
        welcome($email);
    }
?>