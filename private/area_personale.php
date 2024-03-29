<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    importActualStyle();
    session_start();

    $profile_type = null;
    $profile_func = null;
    $auth = null;

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        // menu di navigazione
        nav_menu();

        check_operation();

        $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
        $result = getUserAuth($connection, $_SESSION["username"]);

        // salvo i permessi che ha l'utente che ha effettuato il login
        if ($result) {
            while($row = ($result->fetch_assoc())) {
                $_SESSION["profile_type"] = $row["tipo_profilo"];
                $_SESSION["profile_func"] = $row["tipo_funzione"];
                $_SESSION["user_auth"] = $row["operazione_permessa"];
            }
        } else
            echo ERROR_DB;

        // permetto determinate funzioni in base al tipo di profilo
        switch($_SESSION["profile_type"]) {
            case "presidente":
                try {
                    $connection = connectToDatabase(DB_HOST, DB_PRESIDENT, PRESIDENT_PW, DB_NAME);
                    welcome($connection, $_SESSION["username"]);
                    $_SESSION["is_president"] = true;
                
                    echo "<label>Effettua una delle seguenti operazioni</label><br><br>";
                } catch (Exception $e) {
                    echo ERROR_GEN . ": " . $e;
                }
            break;

            case "admin":
                try {
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    welcome($connection, $_SESSION["username"]);
                    $_SESSION["is_admin"] = true;

                    echo "<br><br><h3>Cosa vuoi fare?</h3>";
                    echo "<br>  <button class='btn'><a href='admin_operation.php?operation=view_user'>GESTIONE UTENTI</a></button><br><br>
                                <button class='btn'><a href='admin_operation.php?operation=view_volu'>GESTIONE VOLONTARI</a></button><br><br>
                                <button class='btn'><a href='admin_operation.php?operation=view_assi'>GESTIONE ASSISTITI</a></button><br><br>
                                <button class='btn'><a href='admin_operation.php?operation=view_terapist'>GESTIONE TERAPISTI</a></button><br><br>
                                <button class='btn'><a href='admin_operation.php?operation=view_president'>GESTIONE PRESIDENTI</a></button><br><br>
                                <button class='btn'><a href='../upload/page_upload.php'>CARICA LIBERATORIE</a></button><br><br>
                                <button class='btn'><a href='admin_operation.php?operation=mng_event'>GESTIONE EVENTI</a></button><br><br>";
                } catch (Exception $e) {
                    echo ERROR_GEN . ": " . $e;
                }
            break;

            case "terapista":
                try {
                    $connection = connectToDatabase(DB_HOST, DB_TERAPIST, TERAPIST_PW, DB_NAME);
                    welcome($connection, $_SESSION["username"]);
                    $_SESSION["is_terapist"] = true;

                    echo "<br><br><h3>Cosa vuoi fare?</h3>";
                } catch (Exception $e) {
                    echo ERROR_GEN . ": " . $e;
                }
            break;

            case "genitore":
                try {
                    $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
                    welcome($connection, $_SESSION["username"]);
                    $_SESSION["is_parent"] = true;

                    // ottengo i dati dell'utente e li stampo
                    echo "<br><br><section id='table'><h3>I tuoi dati</h3>";
                    $query = "SELECT u.id, 
                                    u.nome,
                                    u.cognome,
                                    u.username,
                                    u.email,
                                    u.telefono_fisso,
                                    u.telefono_mobile,
                                    u.note
                                FROM utenti u
                                WHERE u.id = '" . $_SESSION["user_id"] . "'";
                    $result = dbQuery($connection, $query);
                    
                    if ($result) {
                        createTable($result, "user");

                        // ottengo i dati degli assistiti collegati a questo utente e li stampo
                        echo "<br><br><h3>I tuoi assistiti</h3>";
                        $query = "SELECT a.id,
                                        a.nome,
                                        a.cognome, 
                                        a.anamnesi,
                                        a.note
                                    FROM assistiti a 
                                    INNER JOIN utenti u ON a.id_referente = u.id
                                    WHERE u.id = '" . $_SESSION["user_id"] . "'";
                        $result = dbQuery($connection, $query);
                        if ($result) {
                            createTable($result, "assisted");
                            echo "</section>";
                        } else 
                            echo ERROR_DB;
                    } else 
                        echo ERROR_DB;
                } catch (Exception $e) {
                    echo ERROR_GEN . ": " . $e;
                }
            break;
        }
    } else
        header("Location: page_login.php");

    
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

    // funzione per la stampa dell'esito dell'operazione eseguita
    function check_operation() {
        if (isset($_SESSION["user_created"]) && $_SESSION["user_created"]) {
            echo ACC_OK;
            $_SESSION["user_created"] = false;
        }
        if (isset($_SESSION["file_uploaded"]) && $_SESSION["file_uploaded"]) {
            echo FILE_OK;
            $_SESSION["file_uploaded"] = false;
        }
        if (isset($_SESSION["file_notUploaded"]) && $_SESSION["file_notUploaded"]) {
            echo ERROR_FILE;
            $_SESSION["file_notUploaded"] = false;
        }
        if (isset($_SESSION["added_to_event"]) && $_SESSION["added_to_event"]) {
            echo EVENT_OK;
            $_SESSION["added_to_event"] = false;
        }
        if (isset($_SESSION["notAdded_to_event"]) && $_SESSION["notAdded_to_event"]) {
            echo ERROR_GEN;
            $_SESSION["notAdded_to_event"] = false;
        }
        if (isset($_SESSION["event_created"]) && $_SESSION["event_created"]) {
            echo EVENT_OK;
            $_SESSION["event_created"] = false;
        }
        if (isset($_SESSION["event_notCreated"]) && $_SESSION["event_notCreated"]) {
            echo ERROR_GEN;
            $_SESSION["event_notCreated"] = false;
        }
    }
?>