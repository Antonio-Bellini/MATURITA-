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
    session_start();

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
                            <li><a href='../private/area_personale.php' class='btn'>Area Personale</a></li>
                        </ul>
                    </div>
                </nav>            
            </section>
        </main>";
?>
<?php
    if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
        if (isset($_SESSION["is_admin"]) && $_SESSION["is_admin"]) {
            if (($_SESSION["profile_func"] === "gestione DB") && ($_SESSION["user_auth"] === "CRUD")) {
                echo "<br><h1>Pagina di registrazione di un genitore/refente</h1><br><br>
                        <section id='form'>
                            <form name='form_user' action='register.php' id='form_register__user' method='POST'>
                                <input type='hidden' name='form_user'>
                                
                                <div id='name_surname__label'>
                                    <label for='nome'>Inserisci il nome</label>
                                    <label for='cognome'>Inserisci il cognome</label>
                                </div>
                                <div id='name_surname__input'>
                                    <input type='text' name='name' id='name' maxlength='30' required> <br>
                        
                                    <input type='text' name='surname' id='surname' maxlength='30' required> <br>
                                </div>
                    
                                <div id='credentials__label'>
                                    <label for='username'>Inserisci lo username</label>
                                    <label for='password'>Crea una password</label>
                                </div>
                                <div id='credentials__input'>
                                    <input type='text' name='username' id='username' maxlength='20' required>
                                    <span id='usernameError'></span> <br>                        
                                    <input type='password' name='password' id='password' maxlength='255' required>
                                </div>
                                
                                <label for='email'>Inserisci l'email</label>
                                <input type='email' name='email' id='email' maxlength='30' required> <br>
                    
                                <div id='phones__label'>
                                    <label for='phone_f'>Inserisci il numero di telefono fisso</label>
                                    <label for='phone_m'>Inserisci il numero di telefono</label>
                                </div>
                                <div id='phones__input'>
                                    <input type='text' name='phone_f' id='phone_f' maxlength='9'> <br>
                                    <input type='text' name='phone_m' id='phone_m' maxlength='9' required> <br>
                                </div>
                                
                                <label for='notes'>Inserisci qualche nota aggiuntiva</label> <br>
                                <textarea name='notes' id='notes' cols='30' rows='10' placeholder='Altre info utili'></textarea> <br><br><br>
                    
                                <input type='submit' class='btn' value='Registra'>
                            </form>
                        </section>";
            }
        } else 
            header("Location: ../index.php");
    }
?>    
</body>
</html>