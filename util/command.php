<?php
    require_once("constants.php");

    // funzione per eseguire una query sul db
    function dbQuery($connection, $query) {
        return $connection -> query($query);
    }

    // funzione per stampare in forma tabellare il risultato di una query
    function createTable($result, $userType) {
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
                        echo "<td>" . printField($value) . "</td>";

                        printButton($userType, $row["id"]);
                    echo "</tr>";
                }
                echo "</table>";
            } else 
                echo RESULT_NONE;
        }
    }

    // funzionio per la stampa di alcuni dati
    function printField($value) {
        if (substr($value, 0, 1) === "/") {
            if (substr($value, 1, (strpos($value, "_")) - 1) === "anamnesi")
                return "</button><a href='../upload/medical_module" . $value . "'>Apri il file</a></button>";
            else 
                return "</button><a href='../upload/release_module". $value . "'>Apri il file</a></button>";
        } else 
            return $value;
    }

    // funzione per la stampa dei bottoni di modifica
    function printButton($userType, $userId) {
        switch ($userType) {
            case "user" :
                echo "<td>
                        <button><a href='crud.php?operation=modify&user={$userId}&profile=user'>Modifica</a></button>
                    </td>";
                break;

            case "assisted":
                echo "<td>
                        <button><a href='crud.php?operation=modify&user={$userId}&profile=assisted'>Modifica</a></button>
                    </td>";
                break;

            case "volunteer":
                echo "<td>
                        <button><a href='crud.php?operation=modify&user={$userId}&profile=volunteer'>Modifica</a></button>
                    </td>";
                break;

            case null:
                echo "<td>
                        <button><a href='crud.php?operation=modify&user={$userId}'>Modifica</a></button>
                    </td>";
                break;
        }
    }

    // funzione per dare il benvenuto stampando nome e cognome
    function welcome($username) {
        $connection = connectToDatabase("localhost", "root", "", DB_NAME);

        $query = "SELECT nome, cognome
                    FROM utenti
                    WHERE username = '$username';";
        $result = dbQuery($connection, $query);

        if ($result) {
            while ($row = ($result->fetch_assoc()))
                echo "<h2>Benvenuto " . $row["nome"] . " " . $row["cognome"] . "</h2>";
        }
    }

    // funzione per criptare la password
    function encryptPassword($password) {
        $salt = generateSalt(32);
        $password .= $salt;

        return hash("sha512", $password) . ":" . $salt;
    }

    // funzione per generare il salt della password
    function generateSalt($length) {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_[]{}<>~`+=,.;/?|';
        $salt = '';

        for ($i = 0; $i < $length; $i++)
            $salt .= $chars[rand(0, strlen($chars) - 1)];
        
        return $salt;
    }

    // funzione per verificare se due password corrispondano
    function checkPassword($password, $DBpassword) {
        $parts = explode(':', $DBpassword);
        $DBpassword_hashed = $parts[0];
        $DBsalt = $parts[1];
        $password_salted = $password . $DBsalt;
        $password_enc = hash("sha512", $password_salted);

        return $password_enc === $DBpassword_hashed;
    }

    // funzione per ottenere i permessi di un utente
    function getUserAuth($connection, $username) {
        $query = "SELECT tp.tipo AS tipo_profilo,
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

    // funzione per mostrare il form di modifica
    function modifyForm($type, $userId) {
        $connection = connectToDatabase("localhost", "root", "", DB_NAME);

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
                echo "<h1>Modifica anagrafica Assistito</h1>";
                echo "<label>Cosa vuoi modificare?<br><br></label>";

                $query = "SELECT a.nome, a.cognome
                        FROM assistiti a
                        INNER JOIN utenti u ON a.id_referente = u.id
                        WHERE u.id = '$userId'";
                $result = dbQuery($connection, $query);

                if ($result) {
                    while ($row = ($result->fetch_assoc())) {
                        echo "<b>NOME: </b>" . $row["nome"] . "<br>";
                        echo "<b>COGNOME: </b>" . $row["cognome"] . "<br><br><br>";
                    }

                    echo "<label><b>NUOVI DATI</b></label>";
                    echo "<form action='update.php' method='POST' id='form_update__assisted'>
                            <input type='hidden' name='type' value='assisted'>
                            <input type='hidden' name='user_id' value='$userId'>

                            <label><br>Nome</label><br>
                            <input type='text' name='new_name'>

                            <label><br>Cognome</label><br>
                            <input type='text' name='new_surname'><br><br><br>
                            
                            <input type='submit' value='ESEGUI'>";
                }
                break;

            case "volunteer":
                echo "<h1>Modifica anagrafica Volontario</h1>";
                echo "<label>Cosa vuoi modificare?<br><br></label>";

                $query = "SELECT nome, cognome, email, telefono_fisso, telefono_mobile
                        FROM volontari
                        WHERE id = '$userId'";
                $result = dbQuery($connection, $query);

                if ($result) {
                    while ($row = ($result->fetch_assoc())) {
                        echo "<b>NOME: </b>" . $row["nome"] . "<br>";
                        echo "<b>COGNOME: </b>" . $row["cognome"] . "<br>";
                        echo "<b>EMAIL: </b>" . $row["email"] . "<br>";
                        echo "<b>TELEFONO FISSO: </b>" . $row["telefono_fisso"] . "<br>";
                        echo "<b>TELEFONO MOBILE: </b>" . $row["telefono_mobile"] . "<br><br><br>";
                    }

                    echo "<label><b>NUOVI DATI</b></label>";
                    echo "<form action='update.php' method='POST' id='form_update__volunteer'>
                            <input type='hidden' name='type' value='volunteer'>
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
                            <input type='text' name='new_tm'><br><br><br>
                            
                            <input type='submit' value='ESEGUI'>";
                }
                break;
        }
    }

    // funzione per mostrare il form per aggiungere un volontario a un evento
    function addVolunteerToEvent() {
        echo "<form name='voluToEvent' action='event.php' id='addVolunteerToEvent' method='POST'>
                <br><br><label>Quale volontario vuoi assegnare all'evento?</label><br>
            </form>";
    }

    // funzione per mostrare il form per aggiungere un assistito a un evento
    function addAssistedToEvent() {
        echo "<form name='' id='addAssistedToEvent' method='POST'>
                ciao2
            </form>";
    }

    // funzione per mostrare il form per creare un nuovo evento
    function createNewEvent() {
        echo "<form name='' id='createNewEvent' method='POST'>
                ciao3
            </form>";
    } 

    // funzione per mostrare il form per creare un nuovo tipo di evento
    function addNewEventType() {
        echo "<form name='' id='addNewEventType' method='POST'>
                ciao4
            </form>";
    }
?>