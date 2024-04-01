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
            (isset($_SESSION["is_terapist"]) && $_SESSION["is_terapist"]) ||
            (isset($_SESSION["is_president"]) && $_SESSION["is_president"])) {
            switch ($operation){
                case "view_user":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        // funzione per la stampa dell'esito dell'operatione eseguita
                        check_operation();

                        echo " <br><br>
                                <section id='form'>
                                    <h3>Quale tipo di utente vuoi visualizzare?</h3><br>
                                    <select id='user_selected'>
                                        <option value='1'>PRESIDENTI REGISTRATI</option>
                                        <option value='2'>ADMIN REGISTRATI</option>
                                        <option value='3'>TERAPISTI REGISTRATI</option>
                                        <option value='4'>GENITORI/REFERENTI REGISTRATI</option>
                                    </select>
                                </section>";

                        echo "<br><br><br><br>
                                <h3 id='user_title'></h3>
                                <section id='table'></section>";

                        echo "  <section id='table'>    
                                    <h3 id='create_title'></h3>
                                    <button class='btn' id='button_parent'><a href='' id='button_title'>Crea account</a></button>
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
                        $query = "SELECT v.id, 
                                        v.NOME, 
                                        v.COGNOME, 
                                        v.EMAIL, 
                                        v.telefono_fisso AS 'TELEFONO FISSO', 
                                        v.telefono_mobile AS 'TELEFONO MOBILE', 
                                        l.LIBERATORIA
                                    FROM volontari v
                                    LEFT JOIN liberatorie l ON v.id_liberatoria = l.id";
                        $result = dbQuery($connection, $query);

                        if ($result)
                            createTable($result, "volunteer");
                        else 
                            echo ERROR_DB;

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
                    $query = "SELECT a.id, 
                                    a.NOME, 
                                    a.COGNOME, 
                                    a.NOTE, 
                                    a.ANAMNESI, 
                                    u.nome AS 'NOME GENITORE', 
                                    u.cognome AS 'COGNOME GENITORE',
                                    l.LIBERATORIA
                                FROM assistiti a
                                LEFT JOIN utenti u ON a.id_referente = u.id
                                LEFT JOIN liberatorie l ON a.id_liberatoria = l.id";
                    $result = dbQuery($connection, $query);

                    if ($result)
                        createTable($result, "assisted");
                    else
                        echo ERROR_DB;

                    echo "<br><br><br><h3>Crea un nuovo account assistito</h3;>
                        <button class='btn'><a href='../register/register_assisted.php'>Crea account</a></button>
                    </section>";
                    break;

                case "mng_rls":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        // funzione per la stampa dell'esito dell'operatione eseguita
                        check_operation();

                        echo " <br><br>
                                <section id='form'>
                                    <h3>Cosa vuoi fare?</h3><br>
                                    <select id='rls_choice'>
                                        <option value='1'>CARICA LIBERATORIE</option>
                                        <option value='2'>GESTISCI LIBERATORIE</option>
                                    </select>
                                    <input type='submit' value='Carica liberatoria' id='up_rls'>
                                </section>";

                        echo "<section id='table'></section>";
                    } else
                        header("Location: ../index.php");
                    break;
                
                case "mng_event":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                        nav_menu();

                        echo "<br>
                                <section id='form'>
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
                        echo "  </section>";
                    } else
                        header("Location: ../index.php");
                    break;

                case null:
                    header("Location: ../index.php");
            }

            show_footer();
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
?>