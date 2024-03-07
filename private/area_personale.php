<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    showMenu();

    echo "QUESTA PAGINA CONTERRÁ L'AREA PERSONALE DELL'UTENTE";

    // query per ottenere i dati dell'utente
    $query = "SELECT u.nome,
                    u.cognome,
                    u.username,
                    u.email,
                    u.telefono_fisso,
                    u.telefono_mobile,
                    u.note,
                    tp.tipo AS tipo_profilo,
                    GROUP_CONCAT(tf.tipo SEPARATOR ',<br>') AS tipo_funzione,
                    p.tipo_operazione AS permesso
                FROM utenti u
                INNER JOIN profili p ON u.id_profilo = p.tipo_profilo
                INNER JOIN tipi_profilo tp ON p.tipo_profilo = tp.id
                INNER JOIN tipi_funzione tf ON p.tipo_funzione = tf.id
                WHERE u.id = '" . $_SESSION["user_id"] . "'";
    $result = dbQuery($connection, $query);
    createTable($result);

    echo "<br>";

    // query per ottenere i dati degli assistiti che hanno come referente un certo utente
    $query = "SELECT a.nome,
                    a.cognome, 
                    a.anamnesi,
                    a.note
                FROM assistiti a 
                INNER JOIN utenti u ON a.id_referente = u.id
                WHERE u.id = '" . $_SESSION["user_id"] . "'";
    $result = dbQuery($connection, $query);
    createTable($result);
?>