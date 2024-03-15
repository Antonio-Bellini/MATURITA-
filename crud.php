<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    $operation = null;
    $userId = null;
    $profileType = null;

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    if (isset($_GET["id"]))
        $userId = $_GET["id"];

    if (isset($_GET["type"]))
        $profileType = $_GET["type"];

    // possibili bottoni cliccati
    switch ($operation) {
        case "read_med":
            showMenu();
        break;

        case "mng_adm":
            showMenu();
        break;

        case "modify":
            showMenu();
            
            switch ($profileType) {
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
                    showMenu();
                    echo "Disconnessione avvenuta con successo"; 
                }
            } else
                header("Location: loginPage.php");
        break;

        case null:
            header("Location: index.php");
        break;
    }
?>