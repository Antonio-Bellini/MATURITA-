<?php 
    define("DB_NAME", "my_esercizibellini");

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
                // creazione della tabella
                echo "<table border='1'>";
                    // creazione dell'header con i nomi delle colonne
                    echo "<tr>";
                        foreach ($header as $key => $value)
                            echo "<th>" . $key . "</th>";
                            echo "<th>Azioni rapide</th>";
                    echo "</tr>";

                    // inserimento della prima riga (quella appena inserita)
                    echo "<tr>";
                        foreach ($header as $key => $value)
                            printField($key, $value);
                            echo "<td>
                                    <button><a href='crud.php?operation=UPDATE&id=" . $header['id'] . "'>Modifica</a></button>
                                    <button><a href='crud.php?operation=DELETE&id=" . $header['id'] . "'>Elimina</a></button>
                                </td>";
                    echo "</tr>";

                // inserimento delle altre righe della tabella
                while($header = $result->fetch_assoc()) {
                    echo "<tr>";
                        foreach ($header as $key => $value) 
                            printField($key, $value);
                            echo "<td>
                                    <button><a href='crud.php?operation=UPDATE&id=" . $header['id'] . "'>Modifica</a></button>
                                    <button><a href='crud.php?operation=DELETE&id=" . $header['id'] . "'>Elimina</a></button>
                                </td>";
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
            case "dataDiNascita":
                echo "<td>" . date('d/m/Y', strtotime($value)) . "</td>";
                break;

            case "regione_di_residenza":
                $qRegion = "SELECT nome FROM regioni WHERE codice = '$value'";
                $queryR = dbQuery($connection, $qRegion);
                $result = $queryR -> fetch_assoc();

                foreach($result as $key => $value)
                    echo "<td>" . $value . "</td>";
                break;

            case "sesso":
                if ($value === "M")
                    echo "<td>Maschio</td>";
                else 
                    echo "<td>Femmina</td>";
                break;

            default:
                echo "<td>" . $value . "</td>";
                break;
        }
    }

    // FUNZIONE che MOSTRA il MENU CRUD
    function crud_menu() {        
        echo "<label>Quale operazione vuoi eseguire? <br><br></label>
                <button><a href='registerPage.php'>CREATE</a></button>
                <button><a href='crud.php?operation=READ'>READ</a></button>
                <button><a href='crud.php?operation=UPDATE'>UPDATE</a></button>
                <button><a href='crud.php?operation=DELETE'>DELETE</a></button>
                <button><a href='crud.php?operation=LOGOUT'>LOGOUT</a></button>";
    }

    // FUNZIONE che MOSTRA il MENU per INSERIRE COSA si VUOLE AGGIORNARE
    function update_menu($connection, $selectedUser) {
        echo "<br><br><br>I tuoi dati attuali:<br>"; 
                $queryRead = "SELECT u.id, 
                                    up.username AS email,
                                    u.nome AS nome_utente, 
                                    u.cognome AS cognome_utente, 
                                    u.sesso, 
                                    u.codice_regione AS regione_di_residenza, 
                                    u.dataDiNascita,
                                    u.note,
                                    GROUP_CONCAT(ts.nome SEPARATOR ',<br>') AS titoliDiStudio
                            FROM utenti u
                            INNER JOIN username_password up ON u.id = up.id_utente
                            LEFT JOIN utenti_titoli ut ON u.id = ut.id_utente
                            LEFT JOIN titolidistudio ts ON ut.codice_titolo = ts.codice
                            WHERE u.id = '$selectedUser'";
                $readResult = dbQuery($connection, $queryRead);
                createTable($readResult);

        echo "<br><br><br>Cosa vuoi modificare?<br><br>";
        echo "<form method='POST' action='crud.php?operation=UPDATE_USER' id='updateMenu'>";
            echo "Modifica il tuo nome ";
            echo "<input type='text' name='new_name'>";

            echo "<br><br>Modifica il tuo cognome ";
            echo "<input type='text' name='new_surname'><br><br>";

            echo "Vuoi cambiare il sesso inserito?";
            echo "<br><label>SI</label>";
            echo "<input type='checkbox' name='new_sex' value='S'>";

            echo "<br><br>Modifica la regione di residenza ";
            echo "<select name='new_region'>";
                    $queryR = "SELECT codice, nome
                                        FROM regioni";
                    $resQueryR = dbQuery($connection, $queryR);

                    if ($resQueryR) {
                        if (($resQueryR -> num_rows) > 0) {
                                echo "<option>---</option>";
                            while ($row = $resQueryR -> fetch_assoc())
                                echo "<option value='" . $row['codice'] . "'>" . $row['nome'] . "</option>";      
                        } else 
                            echo "<option>Nessuna regione disponibile</option>";
                    } else
                        echo "Si é verificato un errore, riprova piú tardi";
            echo "</select>";

            echo "<br><br>Modifica la data di nascita ";
            echo "<input type='date' name='new_date' onclick='checkInputDate()'>";

            echo "<br><br>Inserisci la vecchia password ";
            echo "<input type='password' name='old_psw' id='old_psw'>";
            echo "<br><br>Inserisci la nuova password ";
            echo "<input type='password' name='new_psw' id='new_psw'>";
            echo "<span id='passwordError'></span>";

            echo "<br><br><br><input type='submit' value='Esegui'>";
        echo "</form>";
    }

    // FUNZIONE che CREA la QUERY di UPDATE in BASE ai DATI INSERITI
    function checkNewValue($connection, $queryUpdate, $new_name, $new_surname, $new_sex, $new_region, $new_date) {
        if (!empty($new_name))
            $queryUpdate .= "nome = '$new_name',";
        
        if (!empty($new_surname))
            $queryUpdate .= "cognome = '$new_surname',";
        
        if (isset($new_sex)) {
            if ($_POST['new_sex'] == 'S') {
                $queryUpdateS = "SELECT sesso
                                FROM utenti
                                WHERE id = '" . $_SESSION['id_utente'] . "'";
                $resUpdate = dbQuery($connection, $queryUpdateS);

                if (($resUpdate -> num_rows) > 0) {
                    while ($row = $resUpdate -> fetch_assoc()) {
                        if ($row['sesso'] == "M")
                            $queryUpdate .= "sesso = 'F',";
                        else
                            $queryUpdate .= "sesso = 'M',";
                    }
                }
            }     
        }

        if ($new_region != '---')
            $queryUpdate .= "codice_regione = '$new_region',";

        if (!empty($new_date))
            $queryUpdate .= "dataDiNascita = '$new_date',";

        $queryUpdate = rtrim($queryUpdate, ", ");

        return $queryUpdate;
    }

    // FUNZIONE per CONTROLLARE che la PASSWORD INSERITA sia CORRETTA
    function check_password($dbPsw, $psw) {
        return hash('sha256', $psw) === $dbPsw;
    }
?>