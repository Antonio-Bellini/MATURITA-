<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    
    importActualStyle();
    $connection = connectToDatabase("localhost", "root", "", DB_NAME);
    session_start();

    $function = null;

    if (isset($_GET["function"]))
        $function = $_GET["function"];

    switch ($function) {
        case "addVolunteerToEvent":
            break;

        case "ff":
            break;
        
        case "createNewEvent":
            $event_type = $_POST["event_type"];
            $event_date = $_POST["event_date"];
            $event_notes = null;

            if (isset($_POST["event_notes"]))
                $event_notes = $_POST["event_notes"];

            $query = "INSERT INTO eventi(tipo_evento, data, note)
                            VALUES('$event_type', '$event_date', '$event_notes');";
            $result = dbQuery($connection, $query);

            if ($result) {
                echo EVENT_OK;
                header("Refresh: 3; URL=area_personale.php");
            } else 
                echo ERROR_GEN;
            break;

        case "gg": 
            break;
    }
    
    
?>