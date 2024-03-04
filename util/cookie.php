<?php
    // funzione per creare un nuovo cookie
    function setNewCookie($button, $name, $value) {
        if (isset($button)) {    
            if ($button == 'Y') {
                $cookie_name = $name;
                $cookie_value = $value;
                $cookie_expire = time() + (86400 * 30);
                setcookie($cookie_name, $cookie_value, $cookie_expire, "/");
            }
        }
            
        importActualStyle();
    }

    // funzione per importare lo stile scelto dall'utente
    function importActualStyle() {
        if(isset($_COOKIE['DarkMode']))
            echo "<body class='" . $_COOKIE['DarkMode'] . "' id='body'>"; 
        else 
            echo "<body class='body' id='body'>";
    }
?>