<?php
    require_once("constants.php");

    // FUNZIONE per ESEGUIRE una QUERY sul DATABASE
    function dbQuery($connection, $query) {
        return $connection -> query($query);
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

        return $password_enc === $DBpassword;
    }
?>