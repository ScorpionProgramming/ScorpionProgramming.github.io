<?php

function connect(){
    $connection = null;
    $db = parse_ini_file("../conf/mysql.ini");

    $host = $db['host'];
    $database = $db['database'];
    $user = $db['user'];
    $password = $db['password'];

    $connection = new mysqli($host, $user, $password, $database);
    // Check connection
    if ($connection->connect_error) {
        die('Could not connect: ' . mysqli_error($con));
    }
    return $connection;
}

function getQueryResult($query){
    $result = null;
    $connection = connect();
    if($connection != null){
        $result = $connection->query($query);
        if (!is_bool($result) && mysqli_num_rows($result) > 0){
            return $result;
        }else{
            return null;
        }
    }
}

function getKurse($schuelerId){
    $klassenKurse = "";
    $query = "SELECT kurs.bezeichnung FROM kurs INNER JOIN schueler_klasse ON schueler_klasse.klasse = kurs.id WHERE schueler_klasse.schueler =".$schuelerId;
    $queryResult = getQueryResult($query);
    if($queryResult != null){
        while($row = mysqli_fetch_row($queryResult)){
            $klassenKurse = $klassenKurse." ".$row[0];
        }
    }
    return $klassenKurse;
}


?>