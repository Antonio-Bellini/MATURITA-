<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="../script/script.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <title>Associazione ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "../util/cookie.php";
    include "../util/command.php";
    importActualStyle();
    session_start();
?>
    <?php
        // menu di navigazione
        nav_menu();

        if (!isset($_SESSION["is_admin"]))
            $_SESSION["is_admin"] = false;

        if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                if (($_SESSION["profile_func"] === "gestione DB") && ($_SESSION["user_auth"] === "CRUD")) {
                    echo "<br><section id='form'>
                            <h2>Pagina di registrazione di un volontario</h2><br>
                                <form name='form_volunteer' action='register.php' id='form_register__volunteer' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='form_volunteer'>

                                    <div id='name_surname__label'>
                                        <label for='name'>Inserisci il nome *</label>
                                        <label for='surname'>Inserisci il cognome *</label>
                                    </div>
                                    <div id='name_surname__input'>
                                        <input type='text' name='name' id='name' maxlength='30' required>
                                        &nbsp;&nbsp;
                                        <input type='text' name='surname' id='surname' maxlength='30' required>
                                    </div>

                                    <label for='email'>Inserisci l'email *</label>
                                    <input type='email' name='email' id='email' maxlength='30' required>

                                    <div id='phones__label'>
                                        <label for='phone_f'>Inserisci il numero del telefono fisso</label>
                                        <label for='phone_m'>Inserisci il numero di telefono *</label>
                                    </div>
                                    <div id='phones__input'>
                                        <input type='text' name='phone_f' id='phone_f' maxlength='9'>
                                        &nbsp;&nbsp;
                                        <input type='text' name='phone_m' id='phone_m' maxlength='9' required>
                                    </div>

                                    <label for='release'>Carica la liberatoria *</label>
                                    <input type='file' name='release' id='release' accept='.pdf' enctype='multipart/form-data' required>

                                    <label for='notes'>Note utili</label>
                                    <textarea name='notes' id='notes' cols='30' rows='10' placeholder='Altre info utili'></textarea>

                                    <input type='submit' value='Crea Account Volontario'>
                                </form>
                            </section>";
                }

                show_footer();
            } else
                header("Location: ../index.php");
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
                                    <li><a href='../bacheca/bacheca.php'        class='btn'>Bacheca       </a></li>
                                    <li><a href='https://stripe.com/it'         class='btn' target='blank'>Donazioni</a></li>
                                    <li><a href='../private/area_personale.php' class='btn'>Area Personale</a></li>
                                </ul>
                            </div>
                        </nav>            
                    </section>
                </main>";
        }
    ?>    
</body>
</html>