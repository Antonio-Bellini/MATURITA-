<?php
    require_once("constants.php");

    // FUNZIONE per ESEGUIRE una QUERY sul DATABASE
    function dbQuery($connection, $query) {
        return $connection -> query($query);
    }

    // FUNZIONE per MOSTRARE il MENU per MOSTRARE le OPERAZIONI POSSIBILI
    function showMenu() {
        echo "  <button><a href='../loginPage.php'>HOME</a></button>
                <button><a href='../newsletter.php'>NEWSLETTER</a></button>
                <button><a href='../bacheca.php'>BACHECA</a></button>
                <button><a href='area_personale.php'>AREA PERSONALE</a></button>
                <button><a href='../private/crud.php?operation=LOGOUT'>LOGOUT</a></button><br><br>";
    }
    function showMenu2() {
        echo "  <button><a href='loginPage.php'>HOME</a></button>
                <button><a href='newsletter.php'>NEWSLETTER</a></button>
                <button><a href='bacheca.php'>BACHECA</a></button>
                <button><a href='private/area_personale.php'>AREA PERSONALE</a></button>
                <button><a href='private/crud.php?operation=LOGOUT'>LOGOUT</a></button><br><br>";
    }

    // FUNZIONE per CREARE UNA TABELLA HTML in BASE ai DATI RICEVUTI dal DATABASE
    function createTable($result) {
        if (!$result)
            echo "Errore nella query: " . $result;
        else {
            if ($header = ($result->fetch_assoc())) {
                echo "<table border='1'>";
                    echo "<tr>";
                        foreach ($header as $key => $value)
                            echo "<th>" . $key . "</th>";
                    echo "</tr>";

                    // riga appena inserita
                    echo "<tr>";
                        foreach ($header as $key => $value)
                            printField($key, $value);
                    echo "</tr>";

                // inserimento delle altre righe della tabella
                while($header = $result->fetch_assoc()) {
                    echo "<tr>";
                        foreach ($header as $key => $value) 
                            printField($key, $value);
                    echo "</tr>";
                }

                echo "</table>";
            } else
                echo "Nessun risultato trovato.";
        }
    }

    // FUNZIONE che FORMATTA in MODO da STAMPARE in una MANIERA piú LEGGIBILE il DATO
    function printField($key, $value) {
        $connection = connectToDatabase(DB_NAME);

        switch($key) {
            default:
                echo "<td>" . $value . "</td>";
                break;
        }
    }

    // FUNZIONE per DARE il BENVENUTO SCRIVENDO il NOME
    function welcome($username) {
        $connection = connectToDatabase(DB_NAME);

        $query = "SELECT nome, cognome
                    FROM utenti u
                    WHERE u.username = '$username';";
        $result = dbQuery($connection, $query);

        if ($result) {
            while ($row = ($result->fetch_assoc()))
                echo "<h2>Benvenuto " . $row["nome"] . "</h2>";
        }
    }

    // FUNZIONE per CRIPTARE la PASSWORD
    function encryptPassword($password) {
        $salt = generateSalt(32);
        $password .= $salt;

        return hash("sha512", $password) . ":" . $salt;
    }

    // FUNZIONE che GENERA un SALE per RENDERE piu SICURA la PASSWORD
    function generateSalt($length) {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_[]{}<>~`+=,.;/?|';
        $salt = '';

        for ($i = 0; $i < $length; $i++)
            $salt .= $chars[rand(0, strlen($chars) - 1)];
        
        return $salt;
    }

    // FUNZIONE per VERIFICARE che DUE PASSWORD CORRISPONDANO
    function checkPassword($password, $DBpassword) {
        $parts = explode(':', $DBpassword);
        $DBpassword_hashed = $parts[0];
        $DBsalt = $parts[1];
        $password_salted = $password . $DBsalt;
        $password_enc = hash("sha512", $password_salted);

        return $password_enc === $DBpassword_hashed;
    }

    // FUNZIONE per OTTENERE le AUTORIZZAZIONI che l'UTENTE HA
    function getUserAuth($connection, $username) {
        $query = "SELECT u.numero_accessi AS accessi_utente,
                        tp.tipo AS tipo_profilo,
                        GROUP_CONCAT(tf.tipo SEPARATOR ',<br>') AS tipo_funzione,
                        p.tipo_operazione AS operazione_permessa
                FROM utenti u 
                INNER JOIN profili p ON p.tipo_profilo = u.id_profilo
                INNER JOIN tipi_profilo tp ON tp.id = p.tipo_profilo
                INNER JOIN tipi_funzione tf ON tf.id = p.tipo_funzione
                WHERE u.username = '$username'
                GROUP BY u.id;";
        $result = dbQuery($connection, $query);

        return $result;
    }

    // FUNZIONE per OTTENERE i DATI di un UTENTE
    function getUserData($connection, $userId) {
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
                WHERE u.id = '$userId'";
        $result = dbQuery($connection, $query);

        return $result;
    }

    // FUNZIONE per OTTENERE i DATI degli ASSISTITI COLLEGATI a un DETERMINATO UTENTE
    function getUserAssisted($connection, $userId) {
        $query = "SELECT a.nome,
                    a.cognome, 
                    a.anamnesi,
                    a.note
                FROM assistiti a 
                INNER JOIN utenti u ON a.id_referente = u.id
                WHERE u.id = '$userId'";
        $result = dbQuery($connection, $query);

        return $result;
    }
?>