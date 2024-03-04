<?php 
    // funzione per connettersi al database
    function connectToDatabase($dbName) {
        $hostName = "localhost";
        $username = "root";
        $password = "";
        
        $connection = new mysqli($hostName, $username, $password, $dbName);
        
        if ($connection -> connect_error)
            die("Connessione fallita: " . ($connection -> connect_error));
        
        return $connection;
    }
?>