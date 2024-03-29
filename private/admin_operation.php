<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    importActualStyle();
    session_start();
    $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

    $operation = null;

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        if ((isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) ||
        (isset($_SESSION["is_terapist"]) && $_SESSION["is_terapist"])) {
            switch ($operation){
                case "view_user":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        // funzione per la stampa dell'esito dell'operatione eseguita
                        check_operation();

                        echo "<br><br><section id='table'><h3>GENITORI/REFERENTI REGISTRATI</h3>";
                        $query = "SELECT id, NOME, COGNOME, USERNAME, EMAIL, telefono_fisso AS 'TELEFONO FISSO', telefono_mobile AS 'TELEFONO MOBILE', NOTE
                                    FROM utenti WHERE id_profilo = 4";
                        $result = dbQuery($connection, $query);
                        if ($result)
                            createTable($result, "user");

                        echo "<br><br><br><h3>Crea un nuovo account genitore/referente</h3;>
                                <button class='btn'><a href='../register/register_user.php'>Crea account</a></button>
                            </section>";
                    } else
                        header("Location: ../index.php");
                    break;

                case "view_volu":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        // funzione per la stampa dell'esito dell'operatione eseguita
                        check_operation();
                        
                        echo "<br><br><section id='table'><h3>VOLONTARI REGISTRATI</h3>";
                        $query = "SELECT v.id, v.NOME, v.COGNOME, v.EMAIL, v.telefono_fisso AS 'TELEFONO FISSO', v.telefono_mobile AS 'TELEFONO MOBILE', l.LIBERATORIA
                                    FROM volontari v
                                    INNER JOIN liberatorie l ON v.id_liberatoria = l.id";
                        $result = dbQuery($connection, $query);
                        if ($result)
                            createTable($result, "volunteer");

                        echo "<br><br><br><h3>Crea un nuovo account volontario</h3;>
                                <button class='btn'><a href='../register/register_volunteer.php'>Crea account</a></button>
                            </section>";
                    } else
                        header("Location: ../index.php");
                    break;

                case "view_assi":
                    nav_menu();

                    // funzione per la stampa dell'esito dell'operatione eseguita
                    check_operation();
                    
                    echo "<br><br><section id='table'><h3>ASSISTITI REGISTRATI</h3>";
                    $query = "SELECT a.id, a.NOME, a.COGNOME, a.NOTE, a.ANAMNESI, 
                                    u.nome AS 'NOME GENITORE', 
                                    u.cognome AS 'COGNOME GENITORE',
                                    l.LIBERATORIA
                                FROM assistiti a
                                INNER JOIN utenti u ON a.id_referente = u.id
                                INNER JOIN liberatorie l ON a.id_liberatoria = l.id";
                    $result = dbQuery($connection, $query);
                    if ($result)
                        createTable($result, "assisted");

                    echo "<br><br><br><h3>Crea un nuovo account assistito</h3;>
                        <button class='btn'><a href='../register/register_assisted.php'>Crea account</a></button>
                    </section>";
                    break;

                case "view_terapist":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        // funzione per la stampa dell'esito dell'operatione eseguita
                        check_operation();

                        echo "<br><br><section id='table'><h3>TERAPISTI REGISTRATI</h3>";
                        $query = "SELECT id, NOME, COGNOME, USERNAME, EMAIL, telefono_fisso AS 'TELEFONO FISSO', telefono_mobile AS 'TELEFONO MOBILE', NOTE
                                    FROM utenti WHERE id_profilo = 3";
                        $result = dbQuery($connection, $query);
                        if ($result)
                            createTable($result, "user");

                        echo "<br><br><br><h3>Crea un nuovo account terapista</h3;>
                                <button class='btn'><a href='../register/register_terapist.php'>Crea account</a></button>
                            </section>";
                    } else
                        header("Location: ../index.php");
                    break;

                case "view_president":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        // funzione per la stampa dell'esito dell'operatione eseguita
                        check_operation();

                        echo "<br><br><section id='table'><h3>PRESIDENTI REGISTRATI</h3>";
                        $query = "SELECT id, NOME, COGNOME, USERNAME, EMAIL, telefono_fisso AS 'TELEFONO FISSO', telefono_mobile AS 'TELEFONO MOBILE', NOTE
                                    FROM utenti WHERE id_profilo = 1";
                        $result = dbQuery($connection, $query);
                        if ($result)
                            createTable($result, "user");

                        echo "<br><br><br><h3>Crea un nuovo account presidente</h3;>
                                <button class='btn'><a href='../register/register_president.php'>Crea account</a></button>
                            </section>";
                    } else
                        header("Location: ../index.php");
                    break;
                
                case "mng_event":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        echo "<br><section id='form'>
                                    <h2>Pagina eventi</h2>
                                    <label>Quale operazione vuoi eseguire?</label>
                                    <select id='mng_event__selected'>
                                        <option value='1'>Aggiungi volontario a evento</option>
                                        <option value='2'>Aggiungi assistito a evento</option>
                                        <option value='3'>Crea nuovo evento</option>
                                        <option value='4'>Aggiungi nuovo tipo di evento</option>
                                        <option value='5'>Visualizza eventi</option>
                                    </select>";
                                    addVolunteerToEvent($connection);
                                    addAssistedToEvent($connection);
                                    createNewEvent($connection);
                                    addNewEventType($connection);
                                    viewVoluEventAssi($connection);
                        echo "  </select>";
                    } else
                        header("Location: ../index.php");
                    break;

                case null:
                    header("Location: ../index.php");
            }
        } else
            header("Location: ../index.php");
    } else
        header("Location: ../page_login.php");

        
    // funzione per mostrare il menu di navigazione
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

    // funzione per la stampa dell'esito dell'operatione eseguita
    function check_operation() {
        if (isset($_SESSION["user_modified"]) && $_SESSION["user_modified"]) {
            echo MOD_OK;
            $_SESSION["user_modified"] = false;
        }
        if (isset($_SESSION["user_deleted"]) && $_SESSION["user_deleted"]) {
            echo DEL_OK;
            $_SESSION["user_deleted"] = false;
        }
        if (isset($_SESSION["user_notModified"]) && $_SESSION["user_notModified"]) {
            echo MOD_NONE;
            $_SESSION["user_notModified"] = false;
        }
    }
?>