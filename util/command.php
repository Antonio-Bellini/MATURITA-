<?php
    require_once("constants.php");

    // FUNZIONE per ESEGUIRE una QUERY sul DATABASE
    function dbQuery($connection, $query) {
        return $connection -> query($query);
    }

    // FUNZIONE per MOSTRARE il MENU per MOSTRARE le OPERAZIONI POSSIBILI
    function showMenu() {
        echo "  <button><a href='index.php'>HOME</a></button>
                <button><a href='newsletter.php'>NEWSLETTER</a></button>
                <button><a href='bacheca.php'>BACHECA</a></button>
                <button><a href='area_personale.php'>AREA PERSONALE</a></button>
                <button><a href='crud.php?operation=LOGOUT'>LOGOUT</a></button><br><br>";
    }

    // FUNZIONE per CREARE UNA TABELLA HTML in BASE ai DATI RICEVUTI dal DATABASE
    function createTable($result, $type) {
        if (!$result)
            echo "Errore nella query: " . $result;
        else {
            if ($header = ($result->fetch_assoc())) {
                echo "<table border='1'>";
                    echo "<tr>";
                        foreach ($header as $key => $value)
                            echo "<th>" . $key . "</th>";

                            echo "<th>bottoni</th>";
                    echo "</tr>";

                    // riga appena inserita
                    echo "<tr>";
                        foreach ($header as $key => $value)
                            printField($key, $value);

                        if ($type == "is_user")
                            echo "<td><button><a href='crud.php?operation=modify&id=" . $_SESSION['user_id'] . "&type=user'>Modifica</a></button></td>";
                        else if ($type == "is_assisted")
                        echo "<td><button><a href='crud.php?operation=modify&id=" . $_SESSION['user_id'] . "&type=assisted'>Modifica</a></button></td>";
                    else 
                        echo "<td><button><a href='crud.php?operation=modify&id=" . $_SESSION['user_id'] . "&type=volunteer'>Modifica</a></button></td>";

                    echo "</tr>";

                // inserimento delle altre righe della tabella
                while($header = $result->fetch_assoc()) {
                    echo "<tr>";
                        foreach ($header as $key => $value)
                            printField($key, $value);
                        
                        if ($type == "is_user")
                            echo "<td><button><a href='crud.php?operation=modify&id=" . $_SESSION['user_id'] . "&type=user'>Modifica</a></button></td>";
                        else if ($type == "is_assisted")
                            echo "<td><button><a href='crud.php?operation=modify&id=" . $_SESSION['user_id'] . "&type=assisted'>Modifica</a></button></td>";
                        else 
                            echo "<td><button><a href='crud.php?operation=modify&id=" . $_SESSION['user_id'] . "&type=volunteer'>Modifica</a></button></td>";
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
                echo "<td align='middle'>" . $value . "</td>";
            break;
        }
    }

    // FUNZIONE per DARE il BENVENUTO SCRIVENDO il NOME e il COGNOME
    function welcome($username) {
        $connection = connectToDatabase(DB_NAME);

        $query = "SELECT nome, cognome
                    FROM utenti
                    WHERE username = '$username';";
        $result = dbQuery($connection, $query);

        if ($result) {
            while ($row = ($result->fetch_assoc()))
                echo "<h2>Benvenuto " . $row["nome"] . " " . $row["cognome"] . "</h2>";
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

    // FUNZIONE per MOSTRARE il FORM di MODIFICA dei DATI
    function modifyForm($type, $userId) {
        $connection = connectToDatabase(DB_NAME);

        switch ($type) {
            case "user":
                echo "<h1>Modifica anagrafica utente</h1>";
                echo "<label>Cosa vuoi modificare?<br><br></label>";

                $query = "SELECT nome, cognome, password, email, telefono_fisso, telefono_mobile
                        FROM utenti 
                        WHERE id = '$userId'";
                $result = dbQuery($connection, $query);

                if ($result){
                    while ($row = ($result->fetch_assoc())) {
                        echo "<b>NOME: </b>" . $row["nome"] . "<br>";
                        echo "<b>COGNOME: </b>" . $row["cognome"] . "<br>";
                        echo "<b>EMAIL: </b>" . $row["email"] . "<br>";
                        echo "<b>TELEFONO FISSO: </b>" . $row["telefono_fisso"] . "<br>";
                        echo "<b>TELEFONO MOBILE: </b>" . $row["telefono_mobile"] . "<br><br><br>";
                    }

                    echo "<label><b>NUOVI DATI</b></label>";
                    echo "<form action='update.php' method='POST' id='form_update__user'>
                            <input type='hidden' name='type' value='user'>
                            <input type='hidden' name='user_id' value='$userId'>

                            <label><br>Nome</label><br>
                            <input type='text' name='new_name'>

                            <label><br>Cognome</label><br>
                            <input type='text' name='new_surname'>

                            <label><br>Email</label><br>
                            <input type='email' name='new_email'>

                            <label><br>Telefono fisso</label><br>
                            <input type='text' name='new_tf'>

                            <label><br>Telefono mobile</label><br>
                            <input type='text' name='new_tm'>

                            <label><br>Password attuale</label><br>
                            <input type='password' name='old_psw' id='old_psw'><br>

                            <label>Nuova password</label><br>
                            <input type='password' name='new_psw' id='new_psw'>
                            <span id='passwordError'></span><br><br><br>

                            <input type='submit' value='ESEGUI'>
                        </form>";
                }
            break;

            case "assisted":
                echo "<h1>Modifica anagrafica assistito</h1>";
                echo "<label>Cosa vuoi modificare?<br><br></label>";
            
                $query = "SELECT nome, cognome
                        FROM assistiti 
                        WHERE id_referente = '$userId'";
                $result = dbQuery($connection, $query);

                if ($result){
                    while ($row = ($result->fetch_assoc())) {
                        echo "<b>NOME: </b>" . $row["nome"] . "<br>";
                        echo "<b>COGNOME: </b>" . $row["cognome"] . "<br>";
                    }

                    echo "<label><b>NUOVI DATI</b></label>";
                    echo "<form action='update.php' method='POST'>
                            <input type='hidden' name='type' value='assisted'>

                            <label><br>Nome</label><br>
                            <input type='text' name='new_name'>

                            <label><br>Cognome</label><br>
                            <input type='text' name='new_surname'>

                            <input type='submit' value='ESEGUI'>
                        </form>";
                }
            break;
        }
    }
?>