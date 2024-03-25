<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    importActualStyle();
    $connection = connectToDatabase(DB_NAME);
    echo "<link rel='stylesheet' href='../style/style.css'>";
    session_start();

    $profile_type = null;
    $profile_func = null;
    $auth = null;

    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        // menu di navigazione
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
                                <li><a href='../newsletter.php'         class='btn'>Newsletter   </a></li>
                                <li><a href='../bacheca.php'            class='btn'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it'     class='btn'>Donazioni     </a></li>
                                <li><a href='area_personale.php'        class='btn'>Area Personale</a></li>
                                <li><a href='crud.php?operation=LOGOUT' class='btn'>Logout</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";

        $result = getUserAuth($connection, $_SESSION["username"]);

        // salvo i permessi che ha l'utente che ha effettuato il login
        if ($result) {
            while($row = ($result->fetch_assoc())) {
                $profile_type = $row["tipo_profilo"];
                $profile_func = $row["tipo_funzione"];
                $auth = $row["operazione_permessa"];
            }
        } else
            echo DB_ERROR;

        // permetto determinate funzioni in base al tipo di profilo
        switch($profile_type) {
            case "presidente":
                welcome($_SESSION["username"]);
                $_SESSION["is_president"] = true;

                echo "<label>Effettua una delle seguenti operazioni</label><br><br>";
                
            break;

            case "admin":
                welcome($_SESSION["username"]);
                $_SESSION["is_admin"] = true;

                echo "<button><a href='admin_operation.php?operation=view_user'>Visualizza utenti</a></button><br><br>";
                echo "<button><a href='admin_operation.php?operation=view_volu'>Visualizza volontari</a></button><br><br>";
                echo "<button><a href='admin_operation.php?operation=view_assi'>Visualizza assistiti</a></button><br><br>";
                echo "<button><a href='../upload/uploadPage.php'>Carica liberatorie</a></button><br><br>";
                echo "<button><a href='admin_operation.php?operation=mng_event'>Pagina eventi</a></button><br><br>";
            break;

            case "terapista":
                welcome($_SESSION["username"]);
                $_SESSION["is_terapist"] = true;

                echo "se leggi sei un terapista";
            break;

            case "genitore":
                welcome($_SESSION["username"]);
                $_SESSION["is_parent"] = true;

                // ottengo i dati dell'utente e li stampo
                echo "I tuoi dati:<br>";
                $query = "SELECT u.id, 
                                u.nome,
                                u.cognome,
                                u.username,
                                u.email,
                                u.telefono_fisso,
                                u.telefono_mobile,
                                u.note
                            FROM utenti u
                            WHERE u.id = '" . $_SESSION["user_id"] . "'";
                $result = dbQuery($connection, $query);
                if ($result) {
                    createTable($result, "user");

                    // ottengo i dati degli assistiti collegati a questo utente e li stampo
                    echo "<br><br>I tuoi assistiti:<br>";
                    $query = "SELECT a.id,
                                    a.nome,
                                    a.cognome, 
                                    a.anamnesi,
                                    a.note
                                FROM assistiti a 
                                INNER JOIN utenti u ON a.id_referente = u.id
                                WHERE u.id = '" . $_SESSION["user_id"] . "'";
                    $result = dbQuery($connection, $query);
                    if ($result) {
                        createTable($result, "assisted");
                    }
                    else 
                        echo DB_ERROR;
                } else 
                    echo DB_ERROR;
            break;
        }
    } else
        header("Location: loginPage.php");
?>