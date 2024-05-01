<?php
    include "../command.php";
    include "../connection.php";
    require_once("../constants.php");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["user_selected"])) {
            $user_selected = $_POST["user_selected"];
            $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

            $query = "SELECT id, 
                            NOME, 
                            COGNOME, 
                            USERNAME, 
                            EMAIL, 
                            telefono_fisso AS 'TELEFONO FISSO', 
                            telefono_mobile AS 'TELEFONO MOBILE', 
                            NOTE
                        FROM utenti 
                        WHERE id_tipo_profilo = $user_selected";
            $result = dbQuery($connection, $query);
            
            if ($result) {
                return createTable($result, "user");
            } else 
                echo ERROR_DB;
        }
    }
?>