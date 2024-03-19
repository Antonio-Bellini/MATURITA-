<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style/style.css">
    <title>Associazione ZeroTre</title>
</head>
<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "util/cookie.php";
    include "util/command.php";
    importActualStyle();
?>
    <!-- SEZIONE PRINCIPALE della PAGINA INDEX -->
    <main>
        <?php
            echo "  <button><a href='index.php'>HOME</a></button>
                    <button><a href='newsletter.php'>NEWSLETTER</a></button>
                    <button><a href='bacheca.php'>BACHECA</a></button>
                    <button><a href='private/area_personale.php'>AREA PERSONALE</a></button>";
        ?>
        <h1>HOME PAGE DEL SITO WEB</h1>
    </main>
</body>
</html>