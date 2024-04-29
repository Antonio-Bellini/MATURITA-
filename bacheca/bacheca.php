<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://kit.fontawesome.com/a730223cdf.js' crossorigin='anonymous'></script>";
    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo WEBALL;
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    echo "<title>Associazione Zero Tre</title>";
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
                <section class='bacheca_newsletter__btn'>
                    <button id='addBachecaBtn' class='btn' data-operation='add' data-table='bacheca'>
                        Aggiungi contenuto
                    </button>
                    &nbsp;
                    <button id='delBachecaBtn' class='btn' data-operation='del' data-table='bacheca'>
                        Elimina contenuto
                    </button>
                </section>";
        } else if (isset($_SESSION["is_parent"]) && $_SESSION["is_parent"]) {
            $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
        }

        // ricerca di contenuti per range di date
        echo "<br><br>
            <section class='bacheca_newsletter__content'>
                <h1>Bacheca dell'associazione</h1><br><br>
                <form id='form' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>
                    <h3>Ricerca dei contenuti in bacheca</h3>
                    <br><br>
                    <div id='name_surname__label'>
                        <label>Inserisci la data di partenza (deve essere nel passato)</label>
                        <label>Inserisci la data di fine (deve essere nel futuro)</label>
                    </div>
                    <div id='name_surname__input'>
                        <input type='date' id='bacheca_start' name='bacheca_start'>
                        &nbsp;&nbsp;
                        <input type='date' id='bacheca_end' name='bacheca_end'>
                    </div>

                    <input type='submit' value='CERCA'>
                </form>";

        // ottengo i record che soddisfano il range di date messo in input
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["bacheca_start"]) && !empty($_POST["bacheca_end"])) {
                $starting_date = $_POST["bacheca_start"];
                $finish_date = $_POST["bacheca_end"];
            } else {                
                $finish_date = date("Y-m-d");
                $starting_date = date("Y-m-d", strtotime("-1 month", strtotime($finish_date)));
            }

            // eseguo la query usando prepared statement per evitare sql injection
            $stmt = $connection->prepare("SELECT bacheca, data FROM bacheca WHERE data BETWEEN ? AND ?");
            $stmt->bind_param("ss", $starting_date, $finish_date);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result) {
                echo "  <section class='bacheca_newsletter__content'>
                            <div class='bacheca_newsletter__list'>";
                if ($result->num_rows === 0)
                    echo "      <h3>Nessun risultato trovato, prova con un intervallo di date diverso</h3>";
                while ($row = ($result->fetch_assoc())) {
                    echo "  <div class='bacheca_newsletter-item'>
                                <div class='pdf-preview'>
                                    <embed src='" . $row["bacheca"] . "' type='application/pdf' width='80%' height='100%'>
                                </div>
                            </div>";
                }
                echo "</div></section>";

                $stmt->close();
            } else 
                echo ERROR_DB;
        }
        
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
                                <li><a href='bacheca.php'                   class='btn btn-sel'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it'         class='btn' target='blank'>Donazioni</a></li>
                                <li><a href='../private/area_personale.php' class='btn'>Area Personale</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
    }
?>