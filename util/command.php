<?php
    require_once("constants.php");

    // funzione per mostrare il footer
    function show_footer() {
        echo "  <footer>
                    <div class='footer-content'>
                        <h5>Dove siamo</h5>
                        <div class='map-container'>
                            <iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d838.2236730786605!2d7.650056144002364!3d45.036350637386306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478812d12cec3a6f%3A0xc06c1b91d782d7d5!2sCorso%20Unione%20Sovietica%2C%20220d%2C%2010134%20Torino%20TO!5e0!3m2!1sit!2sit!4v1711472330414!5m2!1sit!2sit'
                                width='450' height='200' 
                                style='border-radius: 10px; border:none;' 
                                allowfullscreen='' 
                                loading='lazy' 
                                referrerpolicy='no-referrer-when-downgrade'>
                            </iframe>
                        </div>
                        <div class='contact-info'>
                            <p>Associazione ZeroTre ODV</p>
                            <p>Sede Legale ed Operativa in Corso Unione Sovietica 220/D, 10126, Torino (TO)</p>
                            <p>Codice Fiscale: 97595870011</p>
                            <p>Contatti: Tel. 339.2405087 - 348 2409182 - Tel. 333.5829421</p>
                            <p>Email: info@zerotreodv.it</p>
                        </div>
                    </div>
                </footer>";
    }

    // funzione per eseguire una query sul db
    function dbQuery($connection, $query) {
        return $connection -> query($query);
    }

    // funzione per stampare in forma tabellare il risultato di una query
    function createTable($result, $userType) {
        if ($result) {
            if (mysqli_num_rows($result) > 0) {
                $excludedColumns = array("id", "ID VOLONTARIO", "ID ASSISTITO", "ID EVENTO");

                echo "<table border='1'>";
                
                // colonne ottenute dalla query
                $column = mysqli_fetch_fields($result);
                
                    // stampa intestazione della tabella in base alle colonne ottenute dalla query
                    echo "<tr>";
                    foreach ($column as $colonna) {
                        if (!in_array($colonna->name, $excludedColumns)) {
                            echo "<th>" . $colonna->name . "</th>";
                        }
                    }
                            echo "<th>      BOTTONI         </th>";
                    echo "</tr>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if (!in_array($key, $excludedColumns))
                            echo "<td>" . printField($value) . "</td>";
                    }
                    if (isset($row["ID EVENTO"])) {
                        if (isset($row["ID VOLONTARIO"]))
                            echo "<td>" . printButton($userType, $row["ID VOLONTARIO"], $row["ID EVENTO"]) . "</td>";
                        else if (isset($row["ID ASSISTITO"]))
                            echo "<td>" . printButton($userType, $row["ID ASSISTITO"], $row["ID EVENTO"]) . "</td>";
                    }
                        
                    else 
                        echo "<td>" . printButton($userType, $row["id"], null) . "</td>";
                    echo "</tr>";
                }
                echo "</table>";
            } else 
                echo RESULT_NONE;
        }
    }
    
    // funzionio per la stampa di alcuni dati
    function printField($value) {
        if (substr($value, 0, 14) === "release_module" || substr($value, 0, 14) === "medical_module")
            return "<button class='table--btn'><a href='../upload/" . $value . "' target='blank'>Apri il file</a></button>";
        else
            return $value;
    }
    
    // funzione per la stampa dei bottoni di modifica
    function printButton($userType, $userId, $eventId) {
        switch ($userType) {
            case "user":
                $result = "";
                $result .= "<button class='table--btn' data-operation='modify' data-user='$userId' data-profile='user'>
                                Modifica
                            </button>&nbsp;&nbsp;";
                if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])
                    $result .= "<button class='btn_delete' data-operation='delete' data-user='$userId' data-profile='user'>
                                    Elimina
                                </button>";
                return $result;
                break;

            case "assisted":
                $result = "";
                if (isset($_SESSION["is_president"]) && $_SESSION["is_president"])
                    return null;
                else {
                    $result .= "<button class='table--btn' data-operation='modify' data-user='$userId' data-profile='assisted'>
                                    Modifica
                                </button>
                                &nbsp;&nbsp;";
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])
                        $result .= "<button class='btn_delete' data-operation='delete' data-user='$userId' data-profile='assisted'>
                                        Elimina
                                    </button>";
                    return $result;
                }
                break;

            case "volunteer":
                return "<button class='table--btn' data-operation='modify' data-user='$userId' data-profile='volunteer'>
                            Modifica
                        </button>
                        &nbsp;&nbsp;
                        <button class='btn_delete' data-operation='delete' data-user='$userId' data-profile='volunteer'>
                            Elimina
                        </button>";
                break;

            case "admin":
                return "<button class='table--btn' data-operation='modify' data-user='$userId' data-profile='admin'>
                            Modifica
                        </button>
                        &nbsp;&nbsp;
                        <button class='btn_delete' data-operation='delete' data-user='$userId' data-profile='admin'>
                            Elimina
                        </button>";
                break;

            case "admin__eventType":
                return "<button class='table--btn' data-operation='modify' data-user='$userId' data-profile='admin__eventType'>
                            Modifica
                        </button>
                        &nbsp;&nbsp;
                        <button class='btn_delete' data-operation='delete' data-user='$userId' data-profile='admin__eventType'>
                            Elimina
                        </button>";
                break;

            case "admin__event":
                return "RIMUOVI <input type='checkbox' name='volunteer_event[]' value='" . $userId . "%" . "$eventId-'>";
                break;

            case "release":
                return "<button class='table--btn' data-operation='modify' data-user='$userId' data-profile='release'>
                            Aggiorna
                        </button>
                        &nbsp;&nbsp;
                        <button class='btn_delete' data-operation='delete' data-user='$userId' data-profile='release'>
                            Elimina
                        </button>";
                break;

            case null:
                return null;
                break;
        }
    }

    // funzione per dare il benvenuto stampando nome e cognome
    function welcome($connection, $username) {
        $query = "SELECT nome, cognome
                    FROM utenti
                    WHERE username = '$username';";
        $result = dbQuery($connection, $query);

        if ($result) {
            while ($row = ($result->fetch_assoc()))
                echo "<br><h2>Benvenuto " . $row["nome"] . " " . $row["cognome"] . "</h2>";
        }
    }

    // funzione per criptare la password con sha512+salt
    function encryptPassword($password) {
        $chars = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ!@#$%^&*()-_[]{}<>~`+=,.;/?|';
        $salt = null;
        for ($i = 0; $i < 32; $i++)
            $salt .= $chars[rand(0, strlen($chars) - 1)];

        $password .= $salt;

        return hash("sha512", $password) . ":" . $salt;
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

    // funzione per mostrare il form per aggiungere un volontario a un evento
    function crud_volunteer_event($connection) {
        $queryV1 = "SELECT id, 
                            nome, 
                            cognome 
                    FROM volontari";
        $queryE1 = "SELECT e.id, 
                            te.tipo, 
                            e.data 
                    FROM eventi e
                    INNER JOIN tipi_evento te ON te.id = e.tipo_evento";
        $queryVE2 = "SELECT v.id AS 'ID VOLONTARIO', 
                            v.NOME, v.COGNOME, 
                            te.tipo AS 'TIPO EVENTO', 
                            e.DATA, 
                            e.NOTE, 
                            e.id AS 'ID EVENTO'
                        FROM volontari v
                        INNER JOIN volontari_evento ve ON v.id = ve.id_volontario
                        INNER JOIN eventi e ON e.id = ve.id_evento
                        INNER JOIN tipi_evento te ON e.tipo_evento = te.id";
        $queryV2 = "SELECT DISTINCT v.id, 
                                    v.nome, 
                                    v.cognome 
                        FROM volontari v
                        INNER JOIN volontari_evento ve ON ve.id_volontario = v.id";
        $queryVE3 = "SELECT v.id, 
                            v.NOME, 
                            v.COGNOME, 
                            te.tipo AS 'TIPO EVENTO', 
                            e.id,
                            e.DATA, 
                            e.NOTE
                        FROM volontari v
                        INNER JOIN volontari_evento ve ON v.id = ve.id_volontario
                        INNER JOIN eventi e ON e.id = ve.id_evento
                        INNER JOIN tipi_evento te ON e.tipo_evento = te.id";
        $resultV1 = dbQuery($connection, $queryV1);
        $resultE1 = dbQuery($connection, $queryE1);
        $resultVE2 = dbQuery($connection, $queryVE2);
        $resultVE3 = dbQuery($connection, $queryVE3);
        $resultV2 = dbQuery($connection, $queryV2);

        if ($resultV1 && $resultE1 && $resultVE2 && $resultV2 && $resultVE3) {
            echo "  <section id='crud__volu_event'>
                        <br><br>
                        <label for='choice'>Cosa vuoi fare?</label>
                        <select name='crud_volu__choice' id='crud_volu__choice'>
                            <option value='1'>Aggiungi volontario a evento</option>
                            <option value='2'>Rimuovi volontario da evento</option>
                            <option value='3'>Aggiorna un volontario a un evento</option>
                            <option value='4'>Visualizza tutti volontari collegati agli eventi</option>
                        </select>

                        <!-- Aggiunta di un volontario a un evento -->
                        <section id='crud_volu__choice1'>
                            <form action='../private/event.php' method='POST'>
                                <input type='hidden' name='crud_volu_event__function' value='addVoluToEvent'>

                                <label for='volunteer'>Quale volontario vuoi assegnare all'evento?</label>
                                <select name='volunteer' id='user'>";
                                    while ($row = ($resultV1->fetch_assoc()))
            echo "                      <option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
            echo "              </select>

                                <label for='event'>A quale evento vuoi assegnare il volontario?</label>
                                <select name='event' id='event'>";
                                    while ($row = ($resultE1->fetch_assoc()))
            echo "                      <option value=" . $row["id"] . ">" . $row["tipo"] . " il " . $row["data"] . "</option>";
            echo "              </select>

                                <label for='event_notes'>Aggiungi qualche nota utile</label>
                                <textarea name='event_notes' cols='30' rows='10' placeholder='Altre info utili'></textarea>

                                <input type='submit' value='AGGIUNGI'>
                            </form>
                        </section>

                        <!-- Rimozione di un volontario da un evento -->
                        <section id='crud_volu__choice2'>
                            <form action='../private/event.php' method='POST'>
                                <input type='hidden' name='crud_volu_event__function' value='delVoluFromEvent'>
                                
                                <label for='volunteer'>Quale volontario vuoi rimuovere dall'evento?</label>";
                                createTable($resultVE2, "admin__event");

            echo "              <input type='submit' value='RIMUOVI'>";
            echo "          </form>";
            echo "      </section>

                        <!-- Aggiornamento di un volontario a un nuovo evento -->
                        <section id='crud_volu__choice3'>
                            <form action='../private/event.php' method='POST'>
                                <input type='hidden' name='crud_volu_event__function' value='updVoluFromEvent'>

                                <label for='volunteer'>Quale volontario vuoi aggiornare?</label>
                                <select name='volunteer'>";
                                    while ($row = ($resultV2->fetch_assoc()))
            echo "                      <option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
            echo "              </select>";

                        // riporto a 0 il puntatore per la lettura del risultato
                        mysqli_data_seek($resultE1, 0);
                    
            echo "              <label for='event'>A quale nuovo evento vuoi assegnare il volontario?</label>
                                <select name='event' id='event'>";
                                    while ($row = ($resultE1->fetch_assoc()))
            echo "                      <option value='" . $row["id"] . "'>" . $row["tipo"] . " il " . $row["data"] . "</option>";
            echo "              </select>

                                <input type='submit' value='AGGIORNA'>
                            </form>
                        </section>

                        <!-- Visualizzazione di tutti i volontari collegati ai vari eventi -->
                        <section id='crud_volu__choice4'>";
                            createTable($resultVE3, null);
            echo "      </section>
                    </section>";
        } else 
            echo ERROR_DB;
    }

    // funzione per mostrare il form per aggiungere un assistito a un evento
    function crud_assisted_event($connection) {
        $queryA = "SELECT id, nome, cognome FROM assistiti";
        $queryE = "SELECT e.id, te.tipo, e.data 
                    FROM eventi e
                    INNER JOIN tipi_evento te ON te.id = e.tipo_evento";
        $queryAE1 = "SELECT a.id AS 'ID ASSISTITO', 
                            a.NOME, a.COGNOME, 
                            te.tipo AS 'TIPO EVENTO', 
                            e.DATA, 
                            e.NOTE, 
                            e.id AS 'ID EVENTO'
                        FROM assistiti a
                        INNER JOIN assistiti_evento ae ON a.id = ae.id_assistito
                        INNER JOIN eventi e ON e.id = ae.id_evento
                        INNER JOIN tipi_evento te ON e.tipo_evento = te.id";
        $queryAE2 = "SELECT a.id, a.NOME, a.COGNOME, te.tipo AS 'TIPO EVENTO', e.DATA, e.NOTE, e.id
                        FROM assistiti a
                        INNER JOIN assistiti_evento ae ON a.id = ae.id_assistito
                        INNER JOIN eventi e ON e.id = ae.id_evento
                        INNER JOIN tipi_evento te ON e.tipo_evento = te.id";
        $resultA = dbQuery($connection, $queryA);
        $resultE = dbQuery($connection, $queryE);
        $resultAE1 = dbQuery($connection, $queryAE1);
        $resultAE2 = dbQuery($connection, $queryAE2);

        if ($resultA && $resultE && $resultAE1 && $resultAE2) {
            echo "  <section id='crud__assi_event'>
                        <br><br>
                        <label for='choice'>Cosa vuoi fare?</label>
                        <select name='crud_assi__choice' id='crud_assi__choice'>
                            <option value='1'>Aggiungi assistito a evento</option>
                            <option value='2'>Rimuovi assistito da evento</option>
                            <option value='3'>Aggiorna un assistito a un nuovo evento</option>
                            <option value='4'>Visualizza tutti gli assistiti collegati agli eventi</option>
                        </select>

                        <!-- Aggiunta di un assistito a un evento -->
                        <section id='crud_assi__choice1'>
                            <form action='../private/event.php' method='POST'>
                                <input type='hidden' name='crud_assi_event__function' value='addAssiToEvent'>

                                <label for='assisted'>Quale assistito vuoi aggiungere all'evento?</label>
                                <select name='assisted'>";
                                    while ($row = ($resultA->fetch_assoc()))
            echo "                      <option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
            echo "              </select>

                                <label for='event'>A quale evento vuoi agiungere l'assistito?</label>
                                <select name='event'>";
                                    while ($row = ($resultE->fetch_assoc()))
            echo "                      <option value=" . $row["id"] . ">" . $row["tipo"] . " il " . $row["data"] . "</option>";
            echo "              </select>

                                <label for='event_notes'>Aggiungi qualche nota utile</label>
                                <textarea name='event_notes' cols='30' rows='10' placeholder='Altre info utili'></textarea>

                                <input type='submit' value='AGGIUNGI'>
                            </form>
                        </section>

                        <!-- Rimozione di un assistito da un evento -->
                        <section id='crud_assi__choice2'>
                            <form action='../private/event.php' method='POST'>
                                <input type='hidden' name='crud_assi_event__function' value='delAssiFromEvent'>
                                
                                <label for='volunteer'>Quale Assistito vuoi rimuovere dall'evento?</label>";
                                createTable($resultAE1, "admin__event");

            echo "              <input type='submit' value='RIMUOVI'>";
            echo "          </form>";
            echo "      </section>";

                        // riporto a 0 il puntatore per la lettura del risultato
                        mysqli_data_seek($resultA, 0);
                        mysqli_data_seek($resultE, 0);

            echo "      <!-- Aggiornamento di un volontario a un nuovo evento -->
                        <section id='crud_assi__choice3'>
                            <form action='../private/event.php' method='POST'>
                                <input type='hidden' name='crud_assi_event__function' value='updAssiFromEvent'>

                                <label for='volunteer'>Quale Assistito vuoi aggiornare?</label>
                                <select name='assisted'>";
                                    while ($row = ($resultA->fetch_assoc()))
            echo "                      <option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
            echo "              </select>";
                    
            echo "              <label for='event'>A quale nuovo evento vuoi assegnare l'assistito?</label>
                                <select name='event' id='event'>";
                                    while ($row = ($resultE->fetch_assoc()))
            echo "                      <option value='" . $row["id"] . "'>" . $row["tipo"] . " il " . $row["data"] . "</option>";
            echo "              </select>

                                <input type='submit' value='AGGIORNA'>
                            </form>
                        </section>

                        <!-- Visualizzazione di tutti gli assisiti collegati agli eventi -->
                        <section id='crud_assi__choice4'>";
                            createTable($resultAE2, null);
            echo "      </section>
                </section>";
        } else 
            echo ERROR_DB;
    }

    // funzione per mostrare il form per creare un nuovo evento
    function crud_event($connection) {
        $query = "SELECT id, tipo FROM tipi_evento";
        $result = dbQuery($connection, $query);

        if ($result) {
            echo "  <section id='crud__event'>
                        <form action='../private/event.php' method='POST'>
                            <br><br>
                            <label for='event_type'>Che tipo di evento sará?</label>
                            <select name='event_type' id='event_type'>";
                                while ($row = ($result->fetch_assoc()))
                                    echo "<option value=" . $row["id"] . ">" . $row["tipo"] . "</option>";
                echo        "</select>

                            <label for='event_date'>Quando si terrá?</label>
                            <input type='date' name='event_date' id='event_date' required>

                            <label for='event_notes'>Aggiungi qualche nota utile sull'evento</label>
                            <textarea name='event_notes' cols='30' rows='10' placeholder='Altre info utili'></textarea>

                            <input type='submit' value='CREA EVENTO'>
                        </form>
                    </section>";
        } else 
            echo ERROR_DB;
    } 

    // funzione per mostrare il form per creare un nuovo tipo di evento
    function crud_eventType($connection) {
        $queryTE1 = "SELECT id, tipo FROM tipi_evento";
        $resultTE1 = dbQuery($connection, $queryTE1);

        if ($resultTE1) {
            echo "  <section id='crud__eventType'>
                        <br><br>
                        <label for='choice'>Cosa vuoi fare?</label>
                        <select name='crud_eventType__choice' id='crud_eventType__choice'>
                            <option value='1'>Crea nuovo tipo di evento</option>
                            <option value='2'>Visualizza, aggiorna o elimina tipo evento</option>
                        </select>

                        <!-- Creazione di un nuovo tipo di evento -->
                        <section id='crud_eventType__choice1'>
                            <form action='../private/event.php' method='POST'>
                                <input type='hidden' name='crud_eventType__function' value='addNewEventType'>
                                
                                <label>Quale sará il nome del nuovo evento?</label>
                                <textarea name='new_event' id='notes' cols='30' rows='10' placeholder='Nome nuovo evento' required></textarea>

                                <input type='submit' value='CREA NUOVO TIPO DI EVENTO'>
                            </form>
                        </section>

                        <!-- Rimozione, aggiornamento e visualizzazione dei tipi di evento -->
                        <section id='crud_eventType__choice2'>
                            <form action='../private/crud.php' method='POST'>
                                <h3>ATTENZIONE!<br>
                                    Se vuoi cancellare un tipo di evento assicurati 
                                    che non esista nessun evento con quel tipo altrimenti verrá cancellato
                                </h3>
                                <section id='table'>
                                    <label for='event'><br><br>Tipi di evento esistenti</label>";
                                    createTable($resultTE1, "admin__eventType");
            echo "              </section>
                            </form>
                        </section>
                    </section>";
        } else 
            echo ERROR_DB;
    }

    // funzione per visualizzare l'associazione tra volontari-eventi-assistiti
    function view_all_event($connection) {
        $query = "SELECT e.id, te.tipo, e.data 
                    FROM eventi e
                    INNER JOIN tipi_evento te ON te.id = e.tipo_evento";
        $result = dbQuery($connection, $query);

        if ($result) {
            echo "<section id='view__all'><form action='../private/event.php' method='POST'>
                    <br><br>
                    <label>Quale tipo di evento vuoi vedere?</label>
                    <select name='event' id='event'>";
                            echo "<option value='all'>Visualizza tutti</option>";
                        while ($row = ($result->fetch_assoc()))
                            echo "<option value=" . $row["id"] . ">" . $row["tipo"] . " il " . $row["data"] . "</option>";
            echo    "</select>

                    <input type='submit' value='CERCA' id='view_all_event'>
                </form></section>";
        } else 
            echo ERROR_DB;
    }

    // funzione per la stampa dell'esito delle operazioni
    function check_operation() {
        if (isset($_SESSION["user_unknown"]) && $_SESSION["user_unknown"]) {
            echo ERROR_UNK_USER;
            $_SESSION["user_unknown"] = false;
        }
        if (isset($_SESSION["user_created"]) && $_SESSION["user_created"]) {
            echo ACC_OK;
            $_SESSION["user_created"] = false;
        }
        if (isset($_SESSION["user_modified"]) && $_SESSION["user_modified"]) {
            echo MOD_OK;
            $_SESSION["user_modified"] = false;
        }
        if (isset($_SESSION["event_modified"]) && $_SESSION["event_modified"]) {
            echo MOD_OK;
            $_SESSION["event_modified"] = false;
        }
        if (isset($_SESSION["user_not_modified"]) && $_SESSION["user_not_modified"]) {
            echo MOD_NONE;
            $_SESSION["user_not_modified"] = false;
        }
        if (isset($_SESSION["event_not_modified"]) && $_SESSION["event_not_modified"]) {
            echo MOD_NONE;
            $_SESSION["event_not_modified"] = false;
        }
        if (isset($_SESSION["user_deleted"]) && $_SESSION["user_deleted"]) {
            echo DEL_OK;
            $_SESSION["user_deleted"] = false;
        }
        if (isset($_SESSION["file_uploaded"]) && $_SESSION["file_uploaded"]) {
            echo FILE_OK;
            $_SESSION["file_uploaded"] = false;
        }
        if (isset($_SESSION["file_not_uploaded"]) && $_SESSION["file_not_uploaded"]) {
            echo ERROR_FILE;
            $_SESSION["file_not_uploaded"] = false;
        }
        if (isset($_SESSION["file_deleted"]) && $_SESSION["file_deleted"]) {
            echo FILE_DEL;
            $_SESSION["file_deleted"] = false;
        }
        if (isset($_SESSION["event_created"]) && $_SESSION["event_created"]) {
            echo EVENT_OK;
            $_SESSION["event_created"] = false;
        }
        if (isset($_SESSION["event_not_created"]) && $_SESSION["event_not_created"]) {
            echo ERROR_GEN;
            $_SESSION["event_not_created"] = false;
        }
        if (isset($_SESSION["added_to_event"]) && $_SESSION["added_to_event"]) {
            echo EVENT_ADD;
            $_SESSION["added_to_event"] = false;
        }
        if (isset($_SESSION["not_added_to_event"]) && $_SESSION["not_added_to_event"]) {
            echo ERROR_GEN;
            $_SESSION["not_added_to_event"] = false;
        }
        if (isset($_SESSION["incorrect_pw"]) && $_SESSION["incorrect_pw"]) {
            echo ERROR_PW;
            $_SESSION["incorrect_pw"] = false;
        }
        if (isset($_SESSION["event_deleted"]) && $_SESSION["event_deleted"]) {
            echo EVENT_DEL;
            $_SESSION["event_deleted"] = false;
        }
    }
?>