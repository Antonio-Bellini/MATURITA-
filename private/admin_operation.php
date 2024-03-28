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
        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
            switch ($operation){
                case "view_user":
                    nav_menu();
                    
                    echo "<label><b>GENITORI/REFERENTI REGISTRATI</b></label>";
                    $query = "SELECT id, nome, cognome, username, email, telefono_fisso, telefono_mobile, note
                                FROM UTENTI WHERE id_profilo = 4";
                    $result = dbQuery($connection, $query);
                    if ($result)
                        createTable($result, "user");

                    echo "<br><br><br><label>Crea un nuovo account genitore/referente</label><br>";
                    echo "<button><a href='../register/register_user.php'>Crea account</a></button>";
                    break;

                case "view_volu":
                    nav_menu();
                    
                    echo "<label><b>VOLONTARI REGISTRATI</b></label>";
                    $query = "SELECT v.id, v.nome, v.cognome, v.email, v.telefono_fisso, v.telefono_mobile, l.liberatoria
                                FROM volontari v
                                INNER JOIN liberatorie l ON v.id_liberatoria = l.id";
                    $result = dbQuery($connection, $query);
                    if ($result)
                        createTable($result, "volunteer");

                    echo "<br><br><br><label>Crea un nuovo account volontario</label><br>";
                    echo "<button><a href='../register/register_volunteer.php'>Crea account</a></button>";
                    break;

                case "view_assi":
                    nav_menu();
                    
                    echo "<label><b>ASSISTITI REGISTRATI</b></label>";
                    $query = "SELECT a.id, a.nome, a.cognome, a.anamnesi, a.note, 
                                    u.nome AS nome_genitore, 
                                    u.cognome AS cognome_genitore,
                                    l.liberatoria
                                FROM assistiti a
                                INNER JOIN utenti u ON a.id_referente = u.id
                                INNER JOIN liberatorie l ON a.id_liberatoria = l.id";
                    $result = dbQuery($connection, $query);
                    if ($result)
                        createTable($result, "assisted");

                    echo "<br><br><br><label>Aggiungi un nuovo assistito</label><br>";
                    echo "<button><a href='../register/register_assisted.php'>Crea account</a></button>";
                    break;


                case "mng_event":
                    nav_menu();

                    echo "<label><b>PAGINA EVENTI</b></label>";
                    echo "<br>Quale operazione vuoi eseguire?<br><br>";
                    echo "<select id='mng_event__selected'>";
                        echo "<option value='1'>Aggiungi volontario a evento</option>";
                        echo "<option value='2'>Aggiungi assistito a evento</option>";
                        echo "<option value='3'>Crea nuovo evento</option>";
                        echo "<option value='4'>Aggiungi nuovo tipo di evento</option>";
                        echo "<option value='5'>Visualizza eventi</option>";
                    echo "</select>";

                    addVolunteerToEvent($connection);
                    addAssistedToEvent($connection);
                    createNewEvent($connection);
                    addNewEventType($connection);
                    viewVoluEventAssi($connection);
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
?>