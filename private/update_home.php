<?php
    require_once("../util/constants.php");
    include("../util/connection.php");
    include("../util/command.php");
    include("../util/cookie.php");

    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $connection = connectToDatabase(DB_HOST, DB_ADMIN, ADMIN_PW, DB_NAME);

        $query = null;
        $new_data = array();
        $update = false;

        $query_check = "SELECT anni_associazione, volontari_attivi, famiglie_aiutate FROM registro_associazione";
        $result_check = dbQuery($connection, $query_check);

        if ($result_check) {
            if ($result_check->num_rows > 0)
                $update = true;
        } else
            echo ERROR_DB;

        if ($update) {
            $query = "UPDATE registro_associazione SET ";

            if (!empty($new_data)) 
                $new_data = array();

            if (!empty($_POST["newYears"])) {
                $new_years = intval($_POST["newYears"]);
                $new_data[] = "anni_associazione = '{$new_years}'";
            }

            if (!empty($_POST["newVolunteers"])) {
                $new_volunteers = intval($_POST["newVolunteers"]);
                $new_data[] = "volontari_attivi = '{$new_volunteers}'";
            }

            if (!empty($_POST["newFamilies"])) {
                $new_family = intval($_POST["newFamilies"]);
                $new_data[] = "famiglie_aiutate = '{$new_family}'";
            }

            if (!empty($new_data)) {
                $query .= implode(", ", $new_data);
            } else {
                $_SESSION["user_not_modified"] = true;
                header("Location: ../index.php");
            }
        } else {
            $years = isset($_POST["newYears"]) ? intval($_POST["newYears"]) : null;
            $activeVolunteers = isset($_POST["newVolunteers"]) ? intval($_POST["newVolunteers"]) : null;
            $helpedFamiles = isset($_POST["newFamilies"]) ? intval($_POST["newFamilies"]) : null;

            $query = "INSERT INTO registro_associazione(anni_associazione, volontari_attivi, famiglie_aiutate) 
                                VALUES($years, $activeVolunteers, $helpedFamiles)";
        }

        $result = dbQuery($connection, $query);

        if ($result) {
            $_SESSION["user_modified"] = true;
            $update = false;
            header("Location: ../index.php");
        } else
            echo ERROR_DB;
    } else 
        header("Location: ../index.php");
?>