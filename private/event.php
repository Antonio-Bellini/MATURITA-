<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='http://52.47.171.54:8080/bootstrap.js'></script>";
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    importActualStyle();
    session_start();
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

    $function = null;

    if (isset($_SESSION["function"]))
        $function = $_SESSION["function"];

    nav_menu();

    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
        switch ($function) {
            case "crud_volunteer_event":
                try {
                    $volunteer = $_POST["volunteer"];
                    $event = $_POST["event"];
                    $notes = null;

                    if (isset($_POST["notes"]))
                        $notes = $_POST["notes"];

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

            case "crud_assisted_event":
                try {
                    $assisted = $_POST["assisted"];
                    $event = $_POST["event"];
                    $notes = null;

                    if (isset($_POST["notes"]))
                        $notes = $_POST["notes"];

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
            
            case "crud_event":
                $event_type = $_POST["event_type"];
                $event_date = $_POST["event_date"];
                $event_notes = null;

                if (isset($_POST["event_notes"]))
                    $event_notes = $_POST["event_notes"];

                $query = "INSERT INTO eventi(tipo_evento, data, note)
                                VALUES('$event_type', '$event_date', '$event_notes');";
                $result = dbQuery($connection, $query);

                if ($result) {
                    $_SESSION["event_created"] = true;
                    $query = "SELECT e.id,
                                    tipo AS 'NOME EVENTO',
                                    data AS 'DATA EVENTO',
                                    note AS 'NOTE EVENTO'
                                FROM eventi e
                                INNER JOIN tipi_evento te ON e.tipo_evento = te.id";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        check_operation();
                        createTable($result, "admin");
                    } else 
                        echo ERROR_DB;
                } else {
                    $_SESSION["event_not_created"] = true;
                    header("Location: area_personale.php");
                }
                break;

            case "crud_eventType": 
                $new_event = $_POST["new_event"];

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

            case "view_all_event":
                $event = $_POST["event"];
                $query = "SELECT e.id,
                                te.tipo AS 'NOME EVENTO',
                                e.data AS 'DATA EVENTO',
                                e.note AS 'NOTE EVENTO',
                                GROUP_CONCAT(DISTINCT CONCAT(a.nome, ' ', a.cognome) SEPARATOR '<br>') AS 'ASSISTITI REGISTRATI',
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
                    echo "<br><br><section id='table'><h3>Lista di tutti gli eventi</h3>";
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