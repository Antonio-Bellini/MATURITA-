<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='script/script.js'></script>";
    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    $operation = null;
    $userId = null;
    $profileType = null;

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    if (isset($_GET["user"]))
        $userId = $_GET["user"];

        // possibili bottoni cliccati
    switch ($operation) {
        case "modify":
            showMenu_logged();
            modifyForm("user", $userId);
        break;

        case "delete":
            echo "hai cliccato il bottone per eliminare uno user";
            break;

        case "LOGOUT":
            if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
                $_SESSION["is_logged"] = false;

                if (session_destroy()) {
                    showMenu_notLogged();
                    echo "<br>Disconnessione avvenuta con successo"; 
                }
            } else
                header("Location: loginPage.php");
            break;

        case null:
            header("Location: index.php");
            break;
    }
?>