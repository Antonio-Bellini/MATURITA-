<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='../script/script.js'></script>";
    
    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    session_start();

    $operation = null;

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        if ($_SESSION["is_admin"]) {
            switch ($operation){
                case "view_user":
                    showMenu_logged();
                    
                    echo "<label><b>UTENTI REGISTRATI</b></label>";
                    $query = "SELECT id, nome, cognome, username, email, telefono_fisso, telefono_mobile, note, numero_accessi
                                FROM UTENTI";
                    $result = dbQuery($connection, $query);
                    if ($result)
                        createTable($result, "user");

                    echo "<br><br><br><label>Crea un nuovo account genitore</label><br>";
                    echo "<button><a href='../register/register_user.php'>Vai alla pagina</a></button>";
                    break;

                case "view_volu":
                    showMenu_logged();
                    
                    echo "<label><b>VOLONTARI REGISTRATI</b></label>";
                    $query = "SELECT v.id, v.nome, v.cognome, v.email, v.telefono_fisso, v.telefono_mobile, l.liberatoria
                                FROM volontari v
                                INNER JOIN liberatorie l ON v.id_liberatoria = l.id";
                    $result = dbQuery($connection, $query);
                    if ($result)
                        createTable($result, "volunteer");

                    echo "<br><br><br><label>Crea un nuovo account volontario</label><br>";
                    echo "<button><a href='../register/register_volunteer.php'>Vai alla pagina</a></button>";
                    break;

                case "view_assi":
                    showMenu_logged();
                    
                    echo "<label><b>ASSISTITI REGISTRATI</b></label>";
                    $query = "SELECT a.id, a.nome, a.cognome, a.anamnesi, a.note, 
                                    u.nome AS nome_genitore, 
                                    u.cognome AS cognome_genitore
                                FROM assistiti a
                                INNER JOIN utenti u ON a.id_referente = u.id";
                    $result = dbQuery($connection, $query);
                    if ($result)
                        createTable($result, "assisted");

                    echo "<br><br><br><label>Aggiungi un nuovo assistito</label><br>";
                    echo "<button><a href='../register/register_assisted.php'>Vai alla pagina</a></button>";
                    break;


                case "mng_event":
                    echo "<label><b>PAGINA EVENTI</b></label>";
                    echo "<br>Quale operazione vuoi eseguire?<br><br>";
                    echo "<select id='mng_event__selected'>";
                        echo "<option value='1'>Assegna volonatrio a evento</option>";
                        echo "<option value='2'>Aggiungi assistito a evento</option>";
                        echo "<option value='3'>Crea nuovo evento</option>";
                        echo "<option value='4'>Aggiungi un nuovo tipo di evento</option>";
                    echo "</select>";

                    addVolunteerToEvent();
                    addAssistedToEvent();
                    createNewEvent();
                    addNewEventType();
                    break;
            }

        } else
            header("Location: index.php");
    }

    // funzione per mostrare il menu di navigazione
    function showMenu_logged() {
        echo "  <button><a href='../index.php'>HOME</a></button>
                <button><a href='../newsletter.php'>NEWSLETTER</a></button>
                <button><a href='../bacheca.php'>BACHECA</a></button>
                <button><a href='area_personale.php'>AREA PERSONALE</a></button>
                <button><a href='crud.php?operation=LOGOUT'>LOGOUT</a></button><br><br>";
    }
?>