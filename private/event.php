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

    // menu di navigazione
    echo "<main>
            <section class='header'>
                <nav>
                    <a href='../index.php'>
                        <img 
                            src='../image/logos/logo.png'
                            class='logo'
                            id='logoImg'
                            alt='logo associazione'
                        />
                    </a>
                    <div class='nav_links' id='navLinks'>
                        <ul>
                            <li><a href='../newsletter.php'         class='btn'>Newsletter   </a></li>
                            <li><a href='../bacheca.php'            class='btn'>Bacheca       </a></li>
                            <li><a href='https://stripe.com/it'     class='btn'>Donazioni     </a></li>
                            <li><a href='area_personale.php'        class='btn'>Area Personale</a></li>
                            <li><a href='crud.php?operation=LOGOUT' class='btn'>Logout</a></li>
                        </ul>
                    </div>
                </nav>            
            </section>
        </main><br><br>";

    switch ($function) {
        case "addVolunteerToEvent":
            $volunteer = $_POST["volunteer"];
            $event = $_POST["event"];
            $notes = null;

            if (isset($_POST["notes"]))
                $notes = $_POST["notes"];

            $query = "INSERT INTO volontari_evento(id_evento, id_volontario, note)
                            VALUES('$event', '$volunteer', '$notes');";
            $result = dbQuery($connection, $query);

            if ($result)
                echo EVENT_OK;
            else 
                echo ERROR_GEN;
            break;

        case "addAssistedToEvent":
            $assisted = $_POST["assisted"];
            $event = $_POST["event"];
            $notes = null;

            if (isset($_POST["notes"]))
                $notes = $_POST["notes"];

            $query = "INSERT INTO assistiti_evento(id_evento, id_assistito, note)
                            VALUES('$event', '$assisted', '$notes');";
            $result = dbQuery($connection, $query);

            if ($result)
                echo EVENT_OK;
            else 
                echo ERROR_GEN;
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

            if ($result)
                echo EVENT_OK;
            else 
                echo ERROR_GEN;
            break;

        case "addNewEventType": 
            $new_event = $_POST["new_event"];

            $query = "INSERT INTO tipi_evento(tipo)
                            VALUES('$new_event');";
            $result = dbQuery($connection, $query);

            if ($result)
                echo EVENT_OK;
            else 
                echo ERROR_GEN;
            break;

        case "viewVoluEventAssi":
            $event = $_POST["event"];
            $query = "SELECT e.id,
                            te.tipo AS evento,
                            e.data AS data_evento,
                            e.note AS note_evento,
            GROUP_CONCAT(DISTINCT CONCAT(a.nome, ' ', a.cognome) SEPARATOR '<br>') AS assistiti,
            GROUP_CONCAT(DISTINCT CONCAT(v.nome, ' ', v.cognome) SEPARATOR '<br>') AS volontari
     FROM eventi e
     INNER JOIN assistiti_evento ae ON e.id = ae.id_evento
     INNER JOIN volontari_evento ve ON e.id = ve.id_evento
     INNER JOIN tipi_evento te ON e.tipo_evento = te.id
     INNER JOIN assistiti a ON a.id = ae.id_assistito
     INNER JOIN volontari v ON v.id = ve.id_volontario
     WHERE e.id = '$event'
     GROUP BY e.id, te.tipo, e.data, e.note;";
            $result = dbQuery($connection, $query);
            if ($result) {
                createTable($result, "admin");
            }
            break;
    }
    
    
?>