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
    $profile = null;

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    if (isset($_GET["user"]))
        $userId = $_GET["user"];

    if (isset($_GET["profile"]))
        $profile = $_GET["profile"];

    // possibili bottoni cliccati
    switch ($operation) {
        case "modify":
            showMenu_logged();
            switch ($profile) {
                case "user":
                    modifyForm("user", $userId);
                    break;

                case "assisted":
                    modifyForm("assisted", $userId);
                    break;

                case "volunteer":
                    modifyForm("volunteer", $userId);
                    break;
            }
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