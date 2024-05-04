<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo WEBALL;
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    echo "<title>Associazione Zero Tre</title>";
    importActualStyle();
    session_start();
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
    
    $operation = isset($_SESSION["operation"]) ? $_SESSION["operation"] : null;

    if (isset($_GET["operation"])) {
        if ($_GET["operation"] === "LOGOUT")
            $operation = $_GET["operation"];
    }

    $userId = isset($_SESSION["user"]) ? $_SESSION["user"] : null;
    $profile = isset($_SESSION["profile"]) ? $_SESSION["profile"] : null;

    if (!isset($operation))
        header("Location: ../index.php");

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

                case "event":
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

                case "eventType":
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
                            $is_deletable = false;

                            $query = "SELECT id_profilo FROM utenti WHERE id = $userId";
                            $result = dbQuery($connection, $query);

                            if ($result) {
                                while ($row = ($result->fetch_assoc())) {
                                    if ($row["id_profilo"] != 2)
                                        $is_deletable = true;
                                }

                                if ($is_deletable) {
                                    $query = "DELETE FROM utenti WHERE id = '$userId'";
                                    $result = dbQuery($connection, $query);
    
                                    if ($result) {
                                        $_SESSION["user_deleted"] = true;
                                        header("Location: area_personale.php");
                                    }  else
                                        echo ERROR_DB;
                                } else {
                                    $_SESSION["impb_del"] = true;
                                    header("Location: area_personale.php");
                                }
                            } else 
                                echo ERROR_DB;
                        }
                        break;

                    case "assisted":
                        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                            $query = "DELETE FROM assistiti WHERE id = '$userId'";
                            $result = dbQuery($connection, $query);

                            if ($result) {
                                $_SESSION["user_deleted"] = true;
                                header("Location: area_personale.php");
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
                                header("Location: area_personale.php");
                            } else 
                                echo ERROR_DB;
                        }
                        break;

                    case "anamnesi":
                        $file_name = null;
                        $query = "SELECT anamnesi FROM assistiti WHERE id = '$userId'";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            while($row = ($result->fetch_assoc())) {
                                $file_name = "../upload/" . $row["anamnesi"];
                            }

                            if (file_exists($file_name)) {
                                if (unlink($file_name)) {
                                    $query = "UPDATE assistiti SET anamnesi = null WHERE id = $userId";
                                    $result = dbQuery($connection, $query);

                                    if ($result) {
                                        $_SESSION["file_deleted"] = true;
                                        header("Location: area_personale.php");
                                    } else 
                                        echo ERROR_DB;
                                } else 
                                    echo ERROR_GEN;
                            } else 
                                echo ERROR_GEN;
                        } else 
                            echo ERROR_DB;
                        break;

                    case "event":
                        $query = "DELETE FROM eventi WHERE id = $userId";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            $_SESSION["event_deleted"] = true;
                            header("Location: area_personale.php");
                        } else 
                            echo ERROR_DB;
                        break;

                    case "release":
                        $file_name = null;
                        $query = "SELECT liberatoria FROM liberatorie WHERE id = '$userId'";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            while($row = ($result->fetch_assoc())) {
                                $file_name = "../upload/" . $row["liberatoria"];
                            }

                            if (file_exists($file_name)) {
                                if (unlink($file_name)) {
                                    $query = "DELETE FROM liberatorie WHERE id = $userId";
                                    $result = dbQuery($connection, $query);

                                    if ($result) {
                                        $_SESSION["file_deleted"] = true;
                                        header("Location: area_personale.php");
                                    } else 
                                        echo ERROR_DB;
                                } else 
                                    echo ERROR_GEN;
                            } else 
                                echo ERROR_GEN;
                        } else 
                            echo ERROR_DB;
                        break;

                    case "eventType":
                        $query = "DELETE FROM tipi_evento WHERE id = $userId";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            $_SESSION["event_deleted"] = true;
                            header("Location: area_personale.php");
                        } else 
                            echo ERROR_DB;
                        break;

                    case "home_news":
                        $file_name = null;
                        $query = "SELECT news FROM news WHERE id = $userId";
                        $result = dbQuery($connection, $query);

                        if ($result) {
                            while ($row = ($result->fetch_assoc()))
                                $file_name = "../image/" . $row["news"];

                            if (file_exists($file_name)) {
                                if (unlink($file_name)) {
                                    $query = "DELETE FROM news WHERE id = $userId";
                                    $result = dbQuery($connection, $query);

                                    if ($result) {
                                        $_SESSION["file_deleted"] = true;
                                        header("Location: ../index.php");
                                    } else 
                                        echo ERROR_DB;
                                } else 
                                    echo ERROR_GEN;
                            } else 
                                echo ERROR_GEN;
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

                                    <div class='div__label'>
                                        <label for='new_name'>Nome</label>
                                        <label for='new_surname'>Cognome</label>
                                    </div>
                                    <div class='div__input'>
                                        <input type='text' name='new_name' maxlength='255' placeholder='" . htmlspecialchars($name) . "'>
                                        &nbsp;&nbsp;
                                        <input type='text' name='new_surname' maxlength='255' placeholder='" . htmlspecialchars($surname) . "'>
                                    </div>

                                    <label><br>Email</label>
                                    <input type='email' name='new_email' maxlength='255' placeholder='" . htmlspecialchars($email) ."'>

                                    <div class='div__label'>
                                        <label for='new_tf'>Telefono fisso</label>
                                        <label for='new_tm'>Telefono mobile</label>
                                    </div>
                                    <div class='div__input'>
                                        <input type='number' id='new_tf' name='new_tf' placeholder='" . $tf . "'>
                                        &nbsp;&nbsp;
                                        <input type='number' id='new_tm' name='new_tm' placeholder='" . $tm . "'>
                                    </div>

                                    <div class='div__label'>
                                        <label for='old_psw'>Password attuale</label>
                                        <label for='new_psw'>Nuova password</label>
                                    </div>
                                    <div class='div__input'>
                                        <input type='password' name='old_psw' id='old_psw'>
                                        &nbsp;&nbsp;
                                        <input type='password' name='new_psw' id='new_psw' maxlength='255'>
                                        <span id='passwordError'></span>
                                        <span id='togglePassword' class='toggle-password span_error'>👁️</span>
                                    </div>

                                    <label for='confirm_password'>Riscrivi la password inserita</label>
                                    <input type='password' name='confirm_password' id='confirm_password' maxlength='255' required>
                                    <span id='confirm_passwordError'></span>

                                    <input type='submit' value='AGGIORNA DATI'>
                                </form>
                        </section>";
                }  else 
                    echo ERROR_DB;
                break;

            case "assisted":
                if ((isset($_SESSION["is_terapist"]) && $_SESSION["is_terapist"]) ||
                    (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])) {
                    $anamnesi = null;
                    $query = "SELECT anamnesi 
                                FROM assistiti a
                                INNER JOIN utenti u ON a.id_referente = u.id
                                WHERE a.id = '$userId'";
                    $result = dbQuery($connection, $query);

                    if ($result) {
                        while ($row = ($result->fetch_assoc()))
                            $anamnesi = $row["anamnesi"];
                        
                        echo "<br>
                                <section id='form'>
                                    <h2>Modifica anamnesi assistito</h2>
                                    <h3>Modifica l'anamnesi dell'assistito<br><br></h3>
                                    
                                    <div class='div__label'>
                                        <label for='anamnesi'>Anamnesi assistito</label>
                                    </div>
                                    <div class='div__input'>
                                        <section id='table'>
                                            <button class='table_btn__file'><a href='../upload/" . $anamnesi . "' target='_blank'>Apri il file</a></button>
                                            &nbsp;&nbsp;
                                            <button class='btn_delete' data-operation='delete' data-user='$userId' data-profile='anamnesi'>Elimina il file</button>
                                            &nbsp;&nbsp;
                                        </section>
                                        <section>
                                            <button class='table_btn' data-user='$userId'><a href='../upload/page_upload_medical.php'>Aggiungi nuovo file</a></button>
                                        </section>
                                    </div>
                                </section>";
                    }  else 
                        echo ERROR_DB;
                }
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

                                    <div class='div__label'>
                                        <label for='new_name'>Nome</label>
                                        <label for='new_surname'>Cognome</label>
                                    </div>

                                    <div class='div__input'>
                                        <input type='text' name='new_name' maxlength='255' placeholder='" . htmlspecialchars($name) . "'>
                                        &nbsp;&nbsp;
                                        <input type='text' name='new_surname' maxlength='255' placeholder='" . htmlspecialchars($surname) . "'>
                                    </div>

                                    <input type='submit' value='AGGIORNA DATI'>
                                </form>
                        </section>";
                }  else 
                    echo ERROR_DB;
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

                                        <div class='div__label'>
                                            <label for='new_name'>Nome</label>
                                            <label for='new_surname'>Cognome</label>
                                        </div>
                                        <div class='div__input'>
                                            <input type='text' name='new_name' maxlength='255' placeholder='" . htmlspecialchars($name) . "'>
                                            &nbsp;&nbsp;
                                            <input type='text' name='new_surname' maxlength='255' placeholder='" . htmlspecialchars($surname) . "'>
                                        </div>
                                        
                                        <label for='new_email'>Email</label>
                                        <input type='email' name='new_email' maxlength='255' placeholder='" . htmlspecialchars($email) . "'>

                                        <div class='div__label'>
                                            <label for='new_tf'>Telefono fisso</label>
                                            <label for='new_tm'>Telefono mobile</label>
                                        </div>
                                        <div class='div__input'>
                                            <input type='number' id='new_tf' name='new_tf' placeholder='" . $tf . "'>
                                            &nbsp;&nbsp;
                                            <input type='number' id='new_tm' name='new_tm' placeholder='" . $tm . "'>
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