<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src='https://code.jquery.com/jquery-3.6.4.min.js'></script>
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

    <!-- SEZIONE PRINCIPALE della PAGINA INDEX -->
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

    <div class="gallery">
        <img class="photo" src="image/content/image1.jpg" alt="immagine 1 della premiazione">
        <img class="photo" src="image/content/image2.jpg" alt="immagine 2 della premiazione">
        <img class="photo" src="image/content/image3.jpg" alt="immagine 3 della premiazione">
    </div>

    <footer>
        <h5>Dove siamo</h5>
        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d838.2236730786605!2d7.650056144002364!3d45.036350637386306!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x478812d12cec3a6f%3A0xc06c1b91d782d7d5!2sCorso%20Unione%20Sovietica%2C%20220d%2C%2010134%20Torino%20TO!5e0!3m2!1sit!2sit!4v1711472330414!5m2!1sit!2sit" 
                width="450" height="200" 
                style="border-radius: 10px; border:none;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
        </iframe>
        <p>Associazione ZeroTre ODV</p>
        <p>Corso Unione Sovietica 220/D, 10126, Torino (TO)</p>
    </footer>
</body>
</html>