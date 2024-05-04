<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='https://kit.fontawesome.com/a730223cdf.js' crossorigin='anonymous'></script>";
    echo WEBALL;
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    echo "<title>Associazione Zero Tre</title>";
    importActualStyle();
    session_start();
    $connection = null;

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        nav_menu();

        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
                
                // funzione per la stampa dell'esito dell'operazione
                check_operation();
                
                echo "<br><br>
                    <section class='bacheca_newsletter__btn'>
                        <button id='addNewsletterBtn' class='btn' data-operation='add' data-table='newsletter'>
                            Aggiungi contenuto
                        </button>
                        &nbsp;
                        <button id='delNewsletterBtn' class='btn' data-operation='del' data-table='newsletter'>
                            Elimina contenuto
                        </button>
                    </section>";
        } else if (isset($_SESSION["is_parent"]) && $_SESSION["is_parent"]) {
            $connection = connectToDatabase(DB_HOST, DB_USER, USER_PW, DB_NAME);
        }  else if (isset($_SESSION["is_terapist"]) && $_SESSION["is_terapist"]) {
            $connection = connectToDatabase(DB_HOST, DB_TERAPIST, TERAPIST_PW, DB_NAME);
        } else if (isset($_SESSION["is_president"]) && $_SESSION["is_president"]) {
            $connection = connectToDatabase(DB_HOST, DB_PRESIDENT, PRESIDENT_PW, DB_NAME);
        }
        
        // form per la ricerca di contenuti compresi in un range di date
        echo "<br><br>
                <section class='bacheca_newsletter__content'>
                    <h1>Newsletter dell'associazione</h1><br><br>
                    <form id='form' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>
                        <h3>Ricerca dei contenuti in newsletter</h3>
                        <br><br>
                        <div class='div__label'>
                            <label>Inserisci la data di partenza (deve essere nel passato)</label>
                            <label>Inserisci la data di fine (deve essere nel futuro)</label>
                        </div>
                        <div class='div__input'>
                            <input type='date' id='bacheca_start' name='newsletter_start'>
                            &nbsp;&nbsp;
                            <input type='date' id='bacheca_end' name='newsletter_end'>
                        </div>

                        <input type='submit' value='CERCA'>
                    </form>
                </section>";

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (!empty($_POST["newsletter_start"]) && !empty($_POST["newsletter_end"])) {
                $starting_date = $_POST["newsletter_start"];
                $finish_date = $_POST["newsletter_end"];
            } else {
                $finish_date = date("Y-m-d");
                $starting_date = date("Y-m-d", strtotime("-1 year", strtotime($finish_date)));
            }

            // eseguo la query usando prepared statement per evitare sql injection
            $stmt = $connection->prepare("SELECT newsletter, data FROM newsletter WHERE data BETWEEN ? AND ?");
            $stmt->bind_param("ss", $starting_date, $finish_date);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result) {
                echo "  <section class='bacheca_newsletter__content'>
                            <div class='bacheca_newsletter__list'>";
                if ($result->num_rows === 0)
                    echo "      <h3 id='bacheca_newsletter__title'>Nessun risultato trovato, prova con un intervallo di date diverso</h3>";
                while ($row = ($result->fetch_assoc())) {
                    echo "  <div class='bacheca_newsletter__list-item'>
                                <div class='bacheca_newsletter__list__pdf-preview'>
                                    <a href='" . $row["newsletter"] . "' target='_blank'>
                                        <embed src='" . $row["newsletter"] ."' type='application/pdf'>
                                        <div class='bacheca_newsletter__list-item__overlay'>
                                            <button class='bacheca_newsletter__list-item__visualize'>Visualizza altro</button>
                                        </div>
                                    </a>
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
                                <li><a href='newsletter.php'                    class='btn btn_sel'>Newsletter   </a></li>
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