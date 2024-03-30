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
    $connection = null;

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        nav_menu();

        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                // funzione per la stampa dell'esito dell'operazione
                check_operation();
                
                $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

                echo "<br><br>
                        <button class='btn'><a href='../private/crud_bacheca_newsletter.php?operation=add&table=newsletter'>Aggiungi contenuto</a></button>
                        &nbsp;
                        <button class='btn'><a href='../private/crud_bacheca_newsletter.php?operation=del&table=newsletter'>Elimina contenuto</a></button>";
        } else if (isset($_SESSION["is_parent"]) && $_SESSION["is_parent"]) {
            $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
        }  else if (isset($_SESSION["is_terapist"]) && $_SESSION["is_terapist"]) {
            $connection = connectToDatabase(DB_HOST, DB_TERAPIST, TERAPIST_PW, DB_NAME);
        } else if (isset($_SESSION["is_president"]) && $_SESSION["is_president"]) {
            $connection = connectToDatabase(DB_HOST, DB_PRESIDENT, PRESIDENT_PW, DB_NAME);
        }

        $query = "SELECT newsletter, data FROM newsletter";
        $result = dbQuery($connection, $query);
        echo "<br><br><h1>Newsletter dell'associazione</h1><br><br>";

        if ($result) {
            while ($row = ($result->fetch_assoc())) {
                echo "  <div class='bacheca-item'>
                            <div class='pdf-preview'>
                                <embed src='" . $row["newsletter"] . "' type='application/pdf' width='80%' height='100%'>
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
                                <li><a href='newsletter.php'                    class='btn'>Newsletter   </a></li>
                                <li><a href='../bacheca/bacheca.php'            class='btn'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it'             class='btn' target='blank'>Donazioni</a></li>
                                <li><a href='../private/area_personale.php'     class='btn'>Area Personale</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }
?>