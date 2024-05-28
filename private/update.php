<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");

    session_start();

    $type = $_POST["type"];
    $userId = $_POST["user_id"];
    $update_query = null;
    $new_data = array();

    if (!empty($new_data)) 
        $new_data = array();

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            switch ($type) {
                case "user":
                    $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
                    $update_query = "UPDATE utenti SET ";

                    if (!empty($_POST["new_name"])) {
                        $new_name = mysqli_real_escape_string($connection, $_POST['new_name']);
                        $new_data[] = "nome = '{$new_name}'";
                    }
                        
                    if (!empty($_POST["new_surname"])) {
                        $new_surname = mysqli_real_escape_string($connection, $_POST['new_surname']);
                        $new_data[] = "cognome = '{$new_surname}'";
                    }

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

                    if (!empty($_POST["new_name"])) {
                        $new_name = mysqli_real_escape_string($connection, $_POST['new_name']);
                        $new_data[] = "nome = '{$new_name}'";
                    }
                        

                    if (!empty($_POST["new_surname"])) {
                        $new_surname = mysqli_real_escape_string($connection, $_POST['new_surname']);
                        $new_data[] = "cognome = '{$new_surname}'";
                    }

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

                    if (!empty($_POST["new_name"])) {
                        $new_name = mysqli_real_escape_string($connection, $_POST['new_name']);
                        $new_data[] = "nome = '{$new_name}'";
                    }

                    if (!empty($_POST["new_surname"])) {
                        $new_surname = mysqli_real_escape_string($connection, $_POST['new_surname']);
                        $new_data[] = "cognome = '{$new_surname}'";
                    }

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

                case "update_eventType":
                    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                    $update_query = "UPDATE tipi_evento SET ";

                    if (!empty($_POST["new_name"])) {
                        $new_name = mysqli_real_escape_string($connection, $_POST['new_name']);
                        $update_query .= "tipo = '{$new_name}' WHERE id = $userId";
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
        } else 
            header("Location: ../index.php");
    } else 
        header("Location: ../index.php");
?>