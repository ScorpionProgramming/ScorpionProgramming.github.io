<?php
    require_once("includes.html");
    require_once("connectDB.php");
    $con = connect();
    if($con != null){
        schuelerToDatabase($con);
    }


    function schuelerToDatabase($connection){
        //$connection = connect();
        if($connection != null){
            if ($_POST['hiddenID'] < 0){
                $id = getNextID();

                $nachname = checkIfEmpty($_POST['nachname']);
                $vorname = checkIfEmpty($_POST['vorname']);
                $email = checkIfEmpty($_POST['email']);
                $geburtstag = checkIfEmpty($_POST['geburtstag']);
                $kurs = checkIfEmpty($_POST['kursKlasse']);
                $query = "INSERT INTO planer.schueler (id, nachname, vorname, email, geburtstag) VALUES ($id, $nachname, $vorname, $email, $geburtstag);";
                $result = $connection->query($query);
            }else{
                update($connection);
            }
            //kurs_schueler($kurs, $id, $connection);

        }else{
            die;
        }
    }

    function update($connection){
        $id = $_POST['hiddenID'];
        $nachname = checkIfEmpty($_POST['nachname']);
        $vorname = checkIfEmpty($_POST['vorname']);
        $email = checkIfEmpty($_POST['email']);
        $geburtstag = checkIfEmpty($_POST['geburtstag']);
        $kurs = checkIfEmpty($_POST['kursKlasse']);
        $query = "UPDATE `planer`.`schueler` SET `nachname`=".$nachname.", `vorname`=".$vorname.", `email`=".$email.", `geburtstag`=".$geburtstag." WHERE  `id`=".$id.";";
        $result = $connection->query($query);
    }

    function kurs_schueler($kursID, $schuelerID, $connection){
        echo intval($kursID);
        if(intval($kursID) > 0){
            $query = "INSERT INTO planer.schueler_klasse (schueler, klasse) VALUES ('".$schuelerID."', $kursID);";
            $connection->query($query);
        }
    }

    function checkIfEmpty($wert){
        return empty($wert) ? "null" : "'$wert'";
    }
    require_once("JSincludes.html");
?>