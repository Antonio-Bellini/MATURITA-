<?php
    require_once("util/constants.php");
    include("util/connection.php");
    include("util/command.php");
    include("util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    $operation = null;

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        if ($_SESSION["is_admin"]) {
            switch ($operation){
                case "view_user":
                    showMenu_logged();
                    
                    echo "<label><b>UTENTI REGISTRATI</b></label>";
                    $query = "SELECT id, nome, cognome, username, email, telefono_fisso, telefono_mobile, note, numero_accessi
                                FROM UTENTI";
                    $result = dbQuery($connection, $query);
                    if ($result)
                        createTable($result);
                    break;

                case "view_volu":
                    showMenu_logged();
                    
                    echo "<label><b>VOLONTARI REGISTRATI</b></label>";
                    $query = "SELECT id, nome, cognome, email, telefono_fisso, telefono_mobile
                                FROM volontari";
                    $result = dbQuery($connection, $query);
                    if ($result)
                        createTable($result);
                    break;

                case "view_assi":
                    showMenu_logged();
                    
                    echo "<label><b>ASSISTITI REGISTRATI</b></label>";
                    $query = "SELECT a.id, a.nome, a.cognome, a.anamnesi, a.note, 
                                    u.nome AS nome_genitore, u.cognome AS cognome_genitore
                                FROM assistiti a
                                INNER JOIN utenti u ON a.id_referente = u.id";
                    $result = dbQuery($connection, $query);
                    if ($result)
                        createTable($result);
                    break;


                case "mng_event":
                    echo "pagina ud";
                    break;
            }

        } else
            header("Location: index.php");
    }
?>