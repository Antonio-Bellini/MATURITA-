<?php
    require_once("constants.php");

// funzione per mostrare il footer
function show_footer() {
    echo "<footer>
            <h5 class='footer-title'>Nonostante le incertezze e le prove che la vita ci presenti, <br> troviamo la volontà di perseverare e di lottare per un futuro migliore.</h5> <!-- Titolo sopra tutto il resto -->
            <br> <hr class='footer-hr'> <br> <br>
            <div class='footer-content'>
                <h5>Dove siamo</h5>
                <div class='map-container'>
                    <iframe src='https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d838.2236730786605!2d7.650056144002364!3d45.036350637386306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478812d12cec3a6f%3A0xc06c1b91d782d7d5!2sCorso%20Unione%20Sovietica%2C%20220d%2C%2010134%20Torino%20TO!5e0!3m2!1sit!2sit!4v1711472330414!5m2!1sit!2sit'
                        width='550' height='207'
                        style='border-radius: 10px; border:none;' 
                        allowfullscreen='' 
                        loading='lazy' 
                        referrerpolicy='no-referrer-when-downgrade'>
                    </iframe>
                </div>
                <div class='contact-info'>
                <p><i class='fa-solid fa-building'></i> &nbsp; Associazione ZeroTre ODV</p>
                <p><i class='fa-solid fa-location-dot'></i> &nbsp; Corso Unione Sovietica 220/D, 10126, Torino (TO)</p>
                <p><i class='fa-solid fa-id-card'></i>  &nbsp;  CF: 97595870011</p>
                
            </div>
                <div class='contact-info-and-social'>
        <!-- Colonna sinistra -->
        <div class='contact-info'>
            <p><i class='fa-solid fa-phone'></i> &nbsp; Tel. +39 339 2405087 <br>
            <i class='fa-solid fa-phone'></i> &nbsp; Tel. +39 348 2409182 <br>
            <i class='fa-solid fa-phone'></i> &nbsp; Tel. +39 333 5829421 <br> </p>
            <p><i class='fa-solid fa-envelope'></i> &nbsp; info@zerotreodv.it</p>
        </div>

        <!-- Colonna destra -->
        <div class='social-buttons'>
            <a href='https://www.instagram.com/zerotre_associazione?igsh=MWZxazBqanN0NnF6ZQ==' class='socialContainer containerOne'>
                <svg class='socialSvg instagramSvg' viewBox='0 0 16 16'> <path d='M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z'></path> </svg>
            </a>
            <a href='https://it-it.facebook.com/zerotreonlus/' class='socialContainer containerTwo'>
                <svg class='socialSvg facebookSvg'viewBox='0 0 320 512' height='0.9em' xmlns='http://www.w3.org/2000/svg'class='svgIcon'fill='white'> <path d='M80 299.3V512H196V299.3h86.5l18-97.8H196V166.9c0-51.7 20.3-71.5 72.7-71.5c16.3 0 29.4 .4 37 1.2V7.9C291.4 4 256.4 0 236.2 0C129.3 0 80 50.5 80 159.4v42.1H14v97.8H80z'></path> </svg>              
            </a>
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
                echo "<table border='1'>";
                
                // colonne ottenute dalla query
                $column = mysqli_fetch_fields($result);
                
                    // stampa intestazione della tabella in base alle colonne ottenute dalla query
                    echo "<tr>";
                    foreach ($column as $colonna)
                        if ($colonna->name !== "id") {
                            echo "<th>" . $colonna->name . "</th>";
                        }
                            echo "<th>      BOTTONI         </th>";
                    echo "</tr>";
                
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>";
                    foreach ($row as $key => $value) {
                        if ($key !== "id")
                            echo "<td>" . printField($value) . "</td>";
                    }
                    echo "<td>" . printButton($userType, $row["id"]) . "</td>";
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
            return "<button class='table--btn_file'><a href='../upload/" . $value . "' target='blank'>Apri il file</a></button>";
        else
            return $value;
    }
    
    // funzione per la stampa dei bottoni di modifica
    function printButton($userType, $userId) {
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

            case "admin" || "admin__volu_event":
                return "<button class='table--btn' data-operation='modify' data-user='$userId' data-profile='admin'>
                            Modifica
                        </button>
                        &nbsp;&nbsp;
                        <button class='btn_delete' data-operation='delete' data-user='$userId' data-profile='admin'>
                            Elimina
                        </button>";
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
        $queryV1 = "SELECT id, nome, cognome FROM volontari";
        $queryE1 = "SELECT e.id, te.tipo, e.data 
                    FROM eventi e
                    INNER JOIN tipi_evento te ON te.id = e.tipo_evento";
        $queryVE2 = "SELECT v.id, v.nome, v.cognome, te.tipo, e.data, e.note 
                        FROM volontari v
                        INNER JOIN volontari_evento ve ON v.id = ve.id_volontario
                        INNER JOIN eventi e ON e.id = ve.id_evento
                        INNER JOIN tipi_evento te ON e.tipo_evento = te.id";
        $queryV2 = "SELECT DISTINCT v.id, v.nome, v.cognome 
                    FROM volontari v
                    INNER JOIN volontari_evento ve ON ve.id_volontario = v.id";
        $queryVE3 = "SELECT v.id, v.nome, v.cognome, te.tipo, e.data, e.note 
                        FROM volontari v
                        INNER JOIN volontari_evento ve ON v.id = ve.id_volontario
                        INNER JOIN eventi e ON e.id = ve.id_evento
                        INNER JOIN tipi_evento te ON e.tipo_evento = te.id";
        $resultV1 = dbQuery($connection, $queryV1);
        $resultE1 = dbQuery($connection, $queryE1);
        $resultVE2 = dbQuery($connection, $queryVE2);
        $resultVE3 = dbQuery($connection, $queryVE3);
        $resultV2 = dbQuery($connection, $queryV2);

        if ($resultV1 && $resultE1) {
            echo "  <section>
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
                            <form action='../private/event.php' id='addVolunteerToEvent' method='POST' class='addVolunteerToEvent'>
                                <label for='volunteer'>Quale volontario vuoi assegnare all'evento?</label>
                                <select name='volunteer' id='user'>";
                                    while ($row = ($resultV1->fetch_assoc()))
                                        echo "<option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
                    echo   "    </select>

                                <label for='event'>A quale evento vuoi assegnare il volontario?</label>
                                <select name='event' id='event'>";
                                    while ($row = ($resultE1->fetch_assoc()))
                                        echo "<option value=" . $row["id"] . ">" . $row["tipo"] . " il " . $row["data"] . "</option>";
                    echo   "    </select>

                                <label for='event_notes'>Aggiungi qualche nota utile</label>
                                <textarea name='event_notes' id='notes' cols='30' rows='10' placeholder='Altre info utili'></textarea>

                                <input type='submit' value='AGGIUNGI' id='sub__addVoluToEvent'>
                            </form>
                        </section>

                        <!-- Rimozione di un volontario da un evento -->
                        <br><br>
                        <section id='crud_volu__choice2'>
                            <label for='volunteer'>Quale volontario vuoi rimuovere dall'evento?</label>";
                            createTable($resultVE2, "admin__volu_event");
                echo "  </section>

                        <!-- Aggiornamento di un volontario a un nuovo evento -->
                        <section id='crud_volu__choice3'>
                            <label for='volunteer'>Quale volontario vuoi aggiornare?</label>
                            <select name='volunteer' id='user'>";
                                while ($row = ($resultV2->fetch_assoc()))
                                    echo "<option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
                    echo   "</select>";

                    mysqli_data_seek($resultE1, 0);
                    
                    echo "  <label for='event'>A quale nuovo evento vuoi assegnare il volontario?</label>
                            <select name='event' id='event'>";
                                while ($row = ($resultE1->fetch_assoc()))
                                    echo "<option value=" . $row["id"] . ">" . $row["tipo"] . " il " . $row["data"] . "</option>";
                    echo   "</select>

                            <input type='submit' value='AGGIUNGI' id='sub__addVoluToEvent'>
                        </section>

                        <!-- Visualizzazione di tutti i volontari collegati ai vari eventi -->
                        <section id='crud_volu__choice4'>";
                            createTable($resultVE3, "admin");
                echo "  </section>
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
        $resultA = dbQuery($connection, $queryA);
        $resultE = dbQuery($connection, $queryE);

        if ($resultA && $resultE) {
            echo "<form action='../private/event.php' id='addAssistedToEvent' method='POST'>
                    <br><br>
                    <label for='assisted'>Quale assistito vuoi aggiungere all'evento?</label>
                    <select name='assisted' id='user'>";
                        while ($row = ($resultA->fetch_assoc()))
                            echo "<option value=" . $row["id"] . ">" . $row["nome"] . " " . $row["cognome"] . "</option>";
            echo    "</select>

                    <label for='event'>A quale evento vuoi agiungere l'assistito?</label>
                    <select name='event' id='event'>";
                        while ($row = ($resultE->fetch_assoc()))
                            echo "<option value=" . $row["id"] . ">" . $row["tipo"] . " il " . $row["data"] . "</option>";
            echo    "</select>

                    <label for='event_notes'>Aggiungi qualche nota utile</label>
                    <textarea name='event_notes' id='notes' cols='30' rows='10' placeholder='Altre info utili'></textarea>

                    <input type='submit' value='AGGIUNGI' id='crud_assisted_event'>
                </form>";
        } else 
            echo ERROR_DB;
    }

    // funzione per mostrare il form per creare un nuovo evento
    function crud_event($connection) {
        $query = "SELECT id, tipo FROM tipi_evento";
        $result = dbQuery($connection, $query);

        if ($result) {
            echo "<form action='../private/event.php' id='createNewEvent' method='POST'>
                        <br><br>
                        <label for='event_type'>Che tipo di evento sará?</label>
                        <select name='event_type' id='event_type'>";
                            while ($row = ($result->fetch_assoc()))
                                echo "<option value=" . $row["id"] . ">" . $row["tipo"] . "</option>";
            echo        "</select>

                        <label for='event_date'>Quando si terrá?</label>
                        <input type='date' name='event_date' id='event_date' required>

                        <label for='event_notes'>Aggiungi qualche nota utile sull'evento</label>
                        <textarea name='event_notes' id='notes' cols='30' rows='10' placeholder='Altre info utili'></textarea>

                        <input type='submit' value='CREA EVENTO' id='crud_event'>
                </form>";
        } else 
            echo ERROR_DB;
    } 

    // funzione per mostrare il form per creare un nuovo tipo di evento
    function crud_eventType() {
        echo "<form action='../private/event.php' id='addNewEventType' method='POST'>
                <br><br>
                <label>Quale sará il nome del nuovo evento?</label>
                <textarea name='new_event' id='notes' cols='30' rows='10' placeholder='Nome nuovo evento' required></textarea>

                <input type='submit' value='CREA NUOVO TIPO DI EVENTO' id='crud_eventType'>
            </form>";
    }

    // funzione per visualizzare l'associazione tra volontari-eventi-assistiti
    function view_all_event($connection) {
        $query = "SELECT e.id, te.tipo, e.data 
                    FROM eventi e
                    INNER JOIN tipi_evento te ON te.id = e.tipo_evento";
        $result = dbQuery($connection, $query);

        if ($result) {
            echo "<form action='../private/event.php' id='viewVoluEventAssi' method='POST'>
                    <br><br>
                    <label>Quale tipo di evento vuoi vedere?</label>
                    <select name='event' id='event'>";
                            echo "<option value='all'>Visualizza tutti</option>";
                        while ($row = ($result->fetch_assoc()))
                            echo "<option value=" . $row["id"] . ">" . $row["tipo"] . " il " . $row["data"] . "</option>";
            echo    "</select>

                    <input type='submit' value='CERCA' id='view_all_event'>
                </form>";
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
        if (isset($_SESSION["event_deleted"]) && $_SESSION["event_deleted"]) {
            echo EVENT_DEL;
            $_SESSION["event_deleted"] = false;
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
    }
?>