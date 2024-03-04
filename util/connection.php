<?php 
    // FUNZIONE per CONNETTERSI al DATABASE
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