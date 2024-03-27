<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    importActualStyle();
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
                                <li><a href='https://stripe.com/it'     class='btn' target='blank'>Donazioni</a></li>
                                <li><a href='area_personale.php'        class='btn'>Area Personale</a></li>
                                <li><a href='crud.php?operation=LOGOUT' class='btn'>Logout</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";

        $connection = connectToDatabase(DB_HOST, "root", "", DB_NAME);
        $result = getUserAuth($connection, $_SESSION["username"]);

        // salvo i permessi che ha l'utente che ha effettuato il login
        if ($result) {
            while($row = ($result->fetch_assoc())) {
                $profile_type = $row["tipo_profilo"];
                $profile_func = $row["tipo_funzione"];
                $auth = $row["operazione_permessa"];
            }
        } else
            echo ERROR_DB;

        // permetto determinate funzioni in base al tipo di profilo
        switch($profile_type) {
            case "presidente":
                try {
                    $connection = connectToDatabase(DB_HOST, USER_PRESIDENT, PRESIDENT_PW, DB_NAME);
                    welcome($connection, $_SESSION["username"]);

                    $_SESSION["is_president"] = true;
                    $_SESSION["profile_type"] = $profile_type;
                    $_SESSION["profile_func"] = $profile_func;
                    $_SESSION["user_auth"] = $auth;

                    echo "<label>Effettua una delle seguenti operazioni</label><br><br>";
                } catch (Exception $e) {
                    echo ERROR_GEN . ": " . $e;
                }
            break;

            case "admin":
                try {
                    $connection = connectToDatabase(DB_HOST, USER_ADMIN, ADMIN_PW, DB_NAME);
                    welcome($connection, $_SESSION["username"]);

                    $_SESSION["is_admin"] = true;
                    $_SESSION["profile_type"] = $profile_type;
                    $_SESSION["profile_func"] = $profile_func;
                    $_SESSION["user_auth"] = $auth;

                    echo "<button><a href='admin_operation.php?operation=view_user'>Visualizza utenti</a></button><br><br>";
                    echo "<button><a href='admin_operation.php?operation=view_volu'>Visualizza volontari</a></button><br><br>";
                    echo "<button><a href='admin_operation.php?operation=view_assi'>Visualizza assistiti</a></button><br><br>";
                    echo "<button><a href='../upload/uploadPage.php'>Carica liberatorie</a></button><br><br>";
                    echo "<button><a href='admin_operation.php?operation=mng_event'>Pagina eventi</a></button><br><br>";
                } catch (Exception $e) {
                    echo ERROR_GEN . ": " . $e;
                }
            break;

            case "terapista":
                try {
                    $connection = connectToDatabase(DB_HOST, USER_TERAPIST, TERAPIST_PW, DB_NAME);
                    welcome($connection, $_SESSION["username"]);

                    $_SESSION["is_terapist"] = true;
                    $_SESSION["profile_type"] = $profile_type;
                    $_SESSION["profile_func"] = $profile_func;
                    $_SESSION["user_auth"] = $auth;

                    echo "se leggi sei un terapista";
                } catch (Exception $e) {
                    echo ERROR_GEN . ": " . $e;
                }
            break;

            case "genitore":
                try {
                    $connection = connectToDatabase(DB_HOST, USER_USER, USER_PW, DB_NAME);
                    welcome($connection, $_SESSION["username"]);
                    
                    $_SESSION["is_parent"] = true;
                    $_SESSION["profile_type"] = $profile_type;
                    $_SESSION["profile_func"] = $profile_func;
                    $_SESSION["user_auth"] = $auth;

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
                        } else 
                            echo ERROR_DB;
                    } else 
                        echo ERROR_DB;
                } catch (Exception $e) {
                    echo ERROR_GEN . ": " . $e;
                }
            break;
        }
    } else
        header("Location: loginPage.php");
?>