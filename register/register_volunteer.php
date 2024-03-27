<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <link rel="stylesheet" href="../style/style.css">
    <script src="../script/script.js"></script>
    <title>Associazione ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "../util/cookie.php";
    importActualStyle();
?>
    <?php
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
                                <li><a href='../newsletter.php'             class='btn'>Newsletter   </a></li>
                                <li><a href='../bacheca.php'                class='btn'>Bacheca       </a></li>
                                <li><a href='https://stripe.com/it'     class='btn' target='blank'>Donazioni</a></li>
                                <li><a href='../private/area_personale.php'    class='btn'>Area Personale</a></li>
                            </ul>
                        </div>
                    </nav>            
                </section>
            </main>";
        session_start();

        if (!isset($_SESSION["is_admin"]))
            $_SESSION["is_admin"] = false;

        if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
            if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
                if (($_SESSION["profile_func"] === "gestione DB") && ($_SESSION["user_auth"] === "CRUD")) {
                    echo "<br><h1>Pagina di registrazione di un volontario</h1><br><br>
                            <section>
                                <form name='form_volunteer' action='register.php' id='form_register__volunteer' method='POST' enctype='multipart/form-data'>
                                    <input type='hidden' name='form_volunteer'>

                                    <label for='name'>Inserisci il nome</label>
                                    <input type='text' name='name' id='name' maxlength='30' required> <br>

                                    <label for='surname'>Inserisci il cognome</label>
                                    <input type='text' name='surname' id='surname' maxlength='30' required> <br>

                                    <label for='email'>Inserisci l'email</label>
                                    <input type='email' name='email' id='email' maxlength='30' required> <br>

                                    <label for='phone_f'>Inserisci il numero del telefono fisso</label>
                                    <input type='text' name='phone_f' id='phone_f' maxlength='9'> <br>

                                    <label for='phone_m'>Inserisci il numero di telefono</label>
                                    <input type='text' name='phone_m' id='phone_m' maxlength='9' required> <br>

                                    <label for='release'>Carica la liberatoria</label>
                                    <input type='file' name='release' id='release' accept='.pdf' enctype='multipart/form-data' required> <br>

                                    <label for='notes'>Note utili</label> <br>
                                    <textarea name='notes' id='notes' cols='30' rows='10' placeholder='Altre info utili'></textarea> <br><br>

                                    <input type='submit' value='Crea Account Volontario'>
                                </form>
                            </section>";
                }
            } else
                header("Location: ../index.php");
        }
    ?>    
</body>
</html>