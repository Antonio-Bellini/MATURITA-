<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");

    echo "<script src='https://kit.fontawesome.com/a730223cdf.js' crossorigin='anonymous'></script>";
    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo WEBALL;
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";
    echo "<title>Associazione Zero Tre</title>";
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
                <h1 class='about__title'>Bacheca dell'associazione</h1><br><br>
                <form id='form' action='" . htmlspecialchars($_SERVER["PHP_SELF"]) . "' method='POST'>
                    <h3>Ricerca dei contenuti in bacheca</h3>
                    <br><br>
                    <div class='div__label'>
                        <label>Inserisci la data di partenza (deve essere nel passato)</label>
                        <label>Inserisci la data di fine (deve essere nel futuro)</label>
                    </div>
                    <div class='div__input'>
                        <input type='date' id='bacheca_start' name='bacheca_start'>
                        &nbsp;&nbsp;
                        <input type='date' id='bacheca_end' name='bacheca_end'>
                    </div>

                    <input type='submit' value='CERCA'>
                </form>
            </section>";

        // ottengo i record che soddisfano il range di date messo in input
        if (($_SERVER["REQUEST_METHOD"] == "POST") || isset($_GET["page"])) {
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (!empty($_POST["bacheca_start"]) && !empty($_POST["bacheca_end"])) {
                    $_SESSION["b_starting_date"] = $_POST["bacheca_start"];
                    $_SESSION["b_finish_date"] = $_POST["bacheca_end"];
                } else {
                    $_SESSION["b_finish_date"] = date("Y-m-d");
                    $_SESSION["b_starting_date"] = date("Y-m-d", strtotime("-1 month", strtotime($_SESSION["b_finish_date"])));
                }
            }

            // query per contare il numero totale di records e di conseguenza stampare i bottoni necessari
            $query = "SELECT COUNT(id) AS total_records FROM bacheca";
            $result = dbQuery($connection, $query);

            if ($result) {
                // salvo il numero totale di record per fare la paginazione
                $row = $result->fetch_assoc();
                $records = $row["total_records"];

                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                $limit = 2;
                $offset = ($page - 1) * $limit;

                $stmt = $connection->prepare("SELECT bacheca, data FROM bacheca WHERE data BETWEEN ? AND ? LIMIT ? OFFSET ?");
                $stmt->bind_param("ssii", $_SESSION["b_starting_date"], $_SESSION["b_finish_date"], $limit, $offset);
                $stmt->execute();
                $result = $stmt->get_result();

                if (!$stmt->error) {
                    echo "  <section class='bacheca_newsletter__content'>
                                <div class='bacheca_newsletter__list'>";
                    if ($result->num_rows === 0)
                        echo "      <h3 id='bacheca_newsletter__title'>Nessun risultato trovato, prova con un intervallo di date diverso</h3>";
                    while ($row = ($result->fetch_assoc())) {
                        echo "      <div class='bacheca_newsletter__list-item'>
                                        <div class='bacheca_newsletter__list__pdf-preview'>
                                            <a href='" . $row["bacheca"] . "' target='_blank'>
                                                <embed src='" . $row["bacheca"] ."' type='application/pdf'>
                                                <div class='bacheca_newsletter__list-item__overlay'>
                                                    <button class='bacheca_newsletter__list-item__visualize'>Visualizza altro</button>
                                                </div>
                                            </a>
                                        </div>
                                    </div>";
                    }
                    echo "      </div>
                                <div class='pagination'>";
                                
                    // stampa di n bottoni tanti quanti sono i record presenti
                    $total_pages = ceil($records / 2);
                    for ($i = 1; $i <= $total_pages; $i++) {
                        echo "      <button class='pagination'>
                                        <a href='bacheca.php?page=$i'>$i</a>
                                    </button>";
                    }
                                    
                    echo "      </div>
                            </section>";

                    $stmt->close();
                } else 
                    echo ERROR_DB;
            } else 
                echo ERROR_DB;
        }
        
        show_footer2();
    } else 
        header("Location: ../private/page_login.php");
?>