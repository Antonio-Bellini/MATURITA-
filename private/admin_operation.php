<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo WEBALL;
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    echo "<title>Associazione Zero Tre</title>";
    importActualStyle();
    session_start();
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

    $operation = isset($_SESSION["operation"]) ? $_SESSION["operation"] : null;

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        if ((isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) ||
            (isset($_SESSION["is_terapist"]) && $_SESSION["is_terapist"]) ||
            (isset($_SESSION["is_president"]) && $_SESSION["is_president"])) {
            switch ($operation){
                case "view_user":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        // funzione per la stampa dell'esito dell'operatione eseguita
                        check_operation();

                        echo "<br><br>
                                <section id='form'>
                                    <h3>Quale tipo di utente vuoi visualizzare?</h3><br>
                                    <select id='user_selected'>
                                        <option value='1'>PRESIDENTI REGISTRATI</option>
                                        <option value='2'>ADMIN REGISTRATI</option>
                                        <option value='3'>TERAPISTI REGISTRATI</option>
                                        <option value='4'>GENITORI/REFERENTI REGISTRATI</option>
                                    </select>
                                </section>";

                        // la stampa avviene tramite ajax dentro la section con id="table"
                        echo "<br><br><br><br>
                            <section class='main'>
                                <h3 id='user_title'></h3>
                                <section id='table'></section>";

                        // la stampa avviene tramite ajax
                        echo "  <section id='table'>    
                                    <h3 id='create_title'></h3>
                                    <button class='btn' id='button_parent'><a href='' id='button_title'>Crea account</a></button>
                                </section>
                            </section>";
                    } else
                        header("Location: ../index.php");
                    break;

                case "view_volunteer":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        // funzione per la stampa dell'esito dell'operatione eseguita
                        check_operation();

                        $query = "SELECT v.id, 
                                        v.NOME, 
                                        v.COGNOME, 
                                        v.EMAIL, 
                                        v.telefono_fisso AS 'TELEFONO FISSO', 
                                        v.telefono_mobile AS 'TELEFONO MOBILE', 
                                        l.LIBERATORIA
                                    FROM volontari v
                                    LEFT JOIN liberatorie l ON v.id_liberatoria = l.id";
                        $result = dbQuery($connection, $query);
                          
                        if ($result) {
                            echo "<br><br>
                                <section id='table'>
                                    <h3>VOLONTARI REGISTRATI</h3>";
                                    createTable($result, "volunteer");
                        } else 
                            echo ERROR_DB;

                        echo "<br><br><br>
                                    <h3>Crea un nuovo account volontario</h3>
                                    <button class='btn'><a href='../register/register_volunteer.php'>Crea account</a></button>
                                </section>";
                    } else
                        header("Location: ../index.php");
                    break;

                case "view_assisted":
                    nav_menu();

                    // funzione per la stampa dell'esito dell'operatione eseguita
                    check_operation();

                    $query = "SELECT a.id, 
                                    a.NOME, 
                                    a.COGNOME, 
                                    a.NOTE, 
                                    a.ANAMNESI, 
                                    u.nome AS 'NOME GENITORE', 
                                    u.cognome AS 'COGNOME GENITORE',
                                    l.LIBERATORIA
                                FROM assistiti a
                                LEFT JOIN utenti u ON a.id_referente = u.id
                                LEFT JOIN liberatorie l ON a.id_liberatoria = l.id";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        echo "<br><br>
                            <section class='main'>
                                <section id='table'>
                                    <h3>ASSISTITI REGISTRATI</h3>";
                                    createTable($result, "assisted");
                    } else
                        echo ERROR_DB;

                    if (isset($_SESSION["is_president"]) && $_SESSION["is_president"]) {
                        echo "</section>"; 
                    } else {
                        echo "<br><br><br>
                                <h3>Crea un nuovo account assistito</h3>
                                <button class='btn'><a href='../register/register_assisted.php'>Crea account</a></button>
                            </section>
                        </section>";
                    }
                    echo "</section>";
                    break;

                case "manage_release":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        // funzione per la stampa dell'esito dell'operatione eseguita
                        check_operation();

                        echo " <br><br>
                                <section id='form'>
                                    <h3>Cosa vuoi fare?</h3><br>
                                    <select id='rls_choice'>
                                        <option value='1'>CARICA LIBERATORIE</option>
                                        <option value='2'>GESTISCI LIBERATORIE</option>
                                    </select>
                                    <input type='submit' value='Carica liberatoria' id='up_rls'>
                                </section>";

                        echo "<section id='table'></section>";
                    } else
                        header("Location: ../index.php");
                    break;
                
                case "manage_event":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        echo "<br>
                                <section id='form'>
                                    <h2>Pagina eventi</h2>
                                    <h3>Quale operazione vuoi eseguire?</h3>
                                    <select id='mng_event__selected'>
                                        <option value='1'>Gestisci i volontari e gli eventi</option>
                                        <option value='2'>Gestisci gli assistiti e gli eventi</option>
                                        <option value='3'>Crea nuovo evento</option>
                                        <option value='4'>Gestisci i tipi di evento</option>
                                        <option value='5'>Visualizza gli eventi</option>
                                    </select>";
                                    crud_volunteer_event($connection);
                                    crud_assisted_event($connection);
                                    crud_event($connection);
                                    crud_eventType($connection);
                                    view_all_event($connection);
                        echo "  </section>";
                    } else
                        header("Location: ../index.php");
                    break;

            }

            show_footer2();
        } else
            header("Location: ../index.php");
    } else
        header("Location: page_login.php");
?>