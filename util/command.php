<?php
    require_once("constants.php");

    // FUNZIONE per ESEGUIRE una QUERY sul DATABASE
    function dbQuery($connection, $query) {
        return $connection -> query($query);
    }

    // FUNZIONE per MOSTRARE il MENU per MOSTRARE le OPERAZIONI POSSIBILI da NON LOGGATI
    function showMenu_notLogged() {
        echo "  <button><a href='index.php'>HOME</a></button>
                <button><a href='newsletter.php'>NEWSLETTER</a></button>
                <button><a href='bacheca.php'>BACHECA</a></button>
                <button><a href='area_personale.php'>AREA PERSONALE</a></button>";
    }

    // FUNZIONE per MOSTRARE il MENU per MOSTRARE le OPERAZIONI POSSIBILI da LOGGATI
    function showMenu_logged() {
        echo "  <button><a href='index.php'>HOME</a></button>
                <button><a href='newsletter.php'>NEWSLETTER</a></button>
                <button><a href='bacheca.php'>BACHECA</a></button>
                <button><a href='area_personale.php'>AREA PERSONALE</a></button>
                <button><a href='crud.php?operation=LOGOUT'>LOGOUT</a></button><br><br>";
    }

    // FUNZIONI per STAMPARE in FORMA TABELLARE i DATI OTTENUTI da una QUERY sul DATABASE
    function createTable($result) {
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table border='1'>";
                
                // colonne ottenute dalla query
                $column = mysqli_fetch_fields($result);
                
                // stampa intestazione della tabella in base alle colonne ottenute dalla query
                echo "<tr>";
                foreach ($column as $colonna)
                    echo "<th>" . $colonna->name . "</th>";
                    echo "<th>Bottoni</th>";
                echo "</tr>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $value) 
                        echo "<td>" . $value . "</td>";
                    echo "<td>
                            <button><a href='crud.php?operation=modify&user=" . $row["id"] . "'>Modifica</a></button>
                        </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else 
                echo "<br><br>Nessun risultato trovato";
        }
    }
    function createTableUser($result) {
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table border='1'>";
                
                // colonne ottenute dalla query
                $column = mysqli_fetch_fields($result);
                
                // stampa intestazione della tabella in base alle colonne ottenute dalla query
                echo "<tr>";
                foreach ($column as $colonna)
                    echo "<th>" . $colonna->name . "</th>";
                    echo "<th>Bottoni</th>";
                echo "</tr>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $value) 
                        echo "<td>" . $value . "</td>";
                    echo "<td>
                            <button><a href='crud.php?operation=modify&user=" . $row["id"] . "&profile=user'>Modifica</a></button>
                        </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else 
                echo "<br><br>Nessun risultato trovato";
        }
    }
    function createTableAssisted($result) {
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                echo "<table border='1'>";
                
                // colonne ottenute dalla query
                $column = mysqli_fetch_fields($result);
                
                // stampa intestazione della tabella in base alle colonne ottenute dalla query
                echo "<tr>";
                foreach ($column as $colonna)
                    echo "<th>" . $colonna->name . "</th>";
                    echo "<th>Bottoni</th>";
                echo "</tr>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $value) 
                        echo "<td>" . $value . "</td>";
                    echo "<td>
                            <button><a href='crud.php?operation=modify&user=" . $row["id"] . "&profile=assisted'>Modifica</a></button>
                        </td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else 
                echo "<br><br>Nessun risultato trovato";
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
                echo "assisted form";
                break;
        }
    }
?>