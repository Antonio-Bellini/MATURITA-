<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    showMenu_logged();

    $type = $_POST["type"];
    $userId = $_POST["user_id"];
    $update_query = null;
    $new_data = array();

    if (!empty($new_data)) 
        $new_data = array();

    switch ($type) {
        case "user":
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

                if ($result)
                    echo "modifiche eseguite con successo";
                else
                    echo "si é verificato un errore";
            } else 
                echo "Nessuna modifica eseguita";
            break;

        case "assisted":
            $update_query = "UPDATE assistiti SET ";

            if (!empty($_POST["new_name"]))
                $new_data[] = "nome = '{$_POST["new_name"]}'";

            if (!empty($_POST["new_surname"]))
                $new_data[] = "cognome = '{$_POST["new_surname"]}'";

            if (!empty($new_data)) {
                $update_query .= implode(", ", $new_data);
                $update_query .= " WHERE id = $userId";
                $result = dbQuery($connection, $update_query);

                if ($result)
                    echo "modifiche eseguite con successo";
                else
                    echo "si é verificato un errore";
            } else 
                echo "Nessuna modifica eseguita";
            break;
    }
?>