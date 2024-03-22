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
        session_start();

        if (!isset($_SESSION["is_admin"]))
            $_SESSION["is_admin"] = false;

        if (isset($_SESSION["is_logged"]) && $_SESSION["is_logged"]) {
            if ($_SESSION["is_admin"]) {
                echo "  <button><a href='../index.php'>HOME</a></button>
                        <button><a href='../newsletter.php'>NEWSLETTER</a></button>
                        <button><a href='../bacheca.php'>BACHECA</a></button>
                        <button><a href='../private/area_personale.php'>AREA PERSONALE</a></button>
                        <button><a href='../private/crud.php?operation=LOGOUT'>LOGOUT</a></button><br><br>";
                echo "<h1>Pagina di registrazione di un volontario</h1>";
                echo "<main>
                        <form action='register.php' name='form_volunteer' id='form_register__volunteer' method='POST' enctype='multipart/form-data'>
                            <input type='hidden' name='form_volunteer'>

                            <label for='name'>Inserisci il nome</label>
                            <input type='text' name='name' id='name' required> <br>

                            <label for='surname'>Inserisci il cognome</label>
                            <input type='text' name='surname' id='surname' required> <br>

                            <label for='email'>Inserisci l'email</label>
                            <input type='email' name='email' id='email' required> <br>

                            <label for='phone_f'>Inserisci il numero del telefono fisso</label>
                            <input type='text' name='phone_f' id='phone_f'> <br>

                            <label for='phone_m'>Inserisci il numero di telefono</label>
                            <input type='text' name='phone_m' id='phone_m' required> <br>

                            <label for='release'>Carica la liberatoria</label>
                            <input type='file' name='release' id='release' accept='.pdf' enctype='multipart/form-data' required> <br>

                            <label for='notes'>Note utili</label> <br>
                            <textarea name='notes' id='notes' cols='30' rows='10' placeholder='Altre info utili'></textarea> <br><br>

                            <input type='submit' value='Crea Account Volontario'>
                        </form>
                    </main>";
            } else
                header("Location: ../index.php");
        }
    ?>    
</body>
</html>