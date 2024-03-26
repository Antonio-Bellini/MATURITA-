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

    $operation = null;

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
                            <li><a href='../private/area_personale.php'        class='btn'>Area Personale</a></li>
                            <li><a href='../private/crud.php?operation=LOGOUT' class='btn'>Logout</a></li>
                        </ul>
                    </div>
                </nav>            
            </section>
        </main>";

    if (isset($_GET["operation"]))
        $operation = $_GET["operation"];

    switch ($_SESSION["profile_type"]) {
        case "presidente":
            $connection = connectToDatabase(DB_HOST, USER_PRESIDENT, PRESIDENT_PW, DB_NAME);
            break;

        case "admin":
            $connection = connectToDatabase(DB_HOST, USER_ADMIN, ADMIN_PW, DB_NAME);
            
            switch ($operation) {
                case "add":
                    echo "<br><br>
                        <form action='../upload/upload.php' method='POST' enctype='multipart/form-data'>
                            <label>Seleziona il file che vuoi aggiungere in bacheca</label><br><br>
                            <input type='file' name='bacheca' accept=''.pdf' enctype='multipart/form-data' required><br><br>

                            <input type='submit' value='Aggiungi'>
                        </form>";
                    break;

                case "del":
                    break;
            }
            break;

        case "terapista":
            $connection = connectToDatabase(DB_HOST, USER_TERAPIST, TERAPIST_PW, DB_NAME);
            break;

        case "genitore":
            $connection = connectToDatabase(DB_HOST, USER_USER, USER_PW, DB_NAME);
            break;
    }
?>