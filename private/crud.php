<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    echo "<script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>";
    echo "<script src='../script/script.js'></script>";
    echo "<link rel='stylesheet' href='../style/style.css'>";

    importActualStyle();
    $connection = connectToDatabase(DB_HOST, USER_ADMIN, ADMIN_PW, DB_NAME);
    session_start();

    $operation = null;
    $userId = null;
    $profile = null;

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    if (isset($_GET["user"]))
        $userId = $_GET["user"];

    if (isset($_GET["profile"]))
        $profile = $_GET["profile"];

    // possibili bottoni cliccati
    switch ($operation) {
        case "modify":
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
    
            if (!isset($userId))
                $userId = $_SESSION["user_id"];
            
            switch ($profile) {
                case "user":
                    if ((isset($_SESSION["is_parent"]) && $_SESSION["is_parent"]) ||
                        (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])) {
                        
                        if (isset($_SESSION["is_parent"]) && $_SESSION["is_parent"]) {
                            $connection = connectToDatabase(DB_HOST, USER_USER, USER_PW, DB_NAME);
                            if ($userId != $_SESSION["user_id"])
                                $userId = $_SESSION["user_id"];
                        }
                        modifyForm($connection, "user", $userId);
                    }
                    break;

                case "assisted":
                    if ((isset($_SESSION["is_parent"]) && $_SESSION["is_parent"]) ||
                        (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]))
                        $connection = connectToDatabase(DB_HOST, USER_USER, USER_PW, DB_NAME);
                        modifyForm($connection, "assisted", $userId);
                    break;

                case "volunteer":
                    if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"])
                        modifyForm($connection, "volunteer", $userId);
                    break;
            }
        break;
        
        case "LOGOUT":
            if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
                $_SESSION["is_logged"] = false;

                if (session_destroy()) {
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
                                        </ul>
                                    </div>
                                </nav>            
                            </section>
                        </main>";
                    echo DISCONNECTION; 
                }
            } else
                header("Location: loginPage.php");
            break;

        case null:
            header("Location: ../index.php");
            break;
    }
?>