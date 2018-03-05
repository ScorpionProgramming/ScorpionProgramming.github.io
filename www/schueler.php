<!doctype html>
<html lang="de">
    <head>
        <?php include("includes.html");?>
    </head>
    <body>
        <?php include("header.html");?>

        <form action="schueler" method="POST">
            <div class="container-fluid">
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="text" placeholder="Vorname" name="vorname" class="form-control" />
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" placeholder="Nachname" name="nachname" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="email"  class="form-control" placeholder="E-Mail" name="email" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="date"  class="form-control" name="geburtstag" />
                    </div>
                    <div class="form-group col-md-3">
                        <input type="dropdown"  class="form-control" placeholder="Kurs" name="kursKlasse" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-1">
                        <button  class="btn btn-dark" name="submit"/>Speichern</button>
                    </div>
                </div>
            </div>
        </form>
        <?php
            displayQueryResult(getAllSchueler());

            if(isset($_POST['submit']))
            {
                schuelerToDatabase();
            }
        ?>
    </body>
</html>

<?php

function getQueryResult($query){
    $result = null;
    $connection = connect();
    if($connection != null){
        $result = $connection->query($query);
        if (mysqli_num_rows($result) > 0){
            return $result;
        }else{
            return null;
        }
    }
}

function getNextID(){
    $nextID = -1;
    $queryResult = getQueryResult("Select MAX(id)+1 from plannerama.schueler");
    if ($queryResult != null){
        $firstrow = mysqli_fetch_row($queryResult);
        return $firstrow[0];
    }
}

function checkIfEmpty($wert){
    return empty($wert) ? "null" : "'$wert'";
}

function schuelerToDatabase(){
    $connection = connect();
    if($connection != null){
        $id = getNextID();
        $nachname = checkIfEmpty($_POST['nachname']);
        $vorname = checkIfEmpty($_POST['vorname']);
        $email = checkIfEmpty($_POST['email']);
        $geburtstag = checkIfEmpty($_POST['geburtstag']);
        $kurs = checkIfEmpty($_POST['kursKlasse']);
        $query = "INSERT INTO plannerama.schueler (id, nachname, vorname, email, geburtstag, kursKlasse) VALUES ($id, $nachname, $vorname, $email, $geburtstag, $kurs);";
        $result = $connection->query($query);
    }
}

function getAllSchueler(){
    $queryResult = getQueryResult("SELECT * from plannerama.schueler");
    return $queryResult;
}

function displayQueryResult($result){
    if ($result->num_rows > 0) {
        // output data of each row
        while($row = $result->fetch_assoc()) {
            echo "id: " . $row["id"]. " - Name: " . $row["nachname"]. " " . $row["vorname"]. "<br>";
        }
    } else {
        echo "0 results";
    }
}

function connect(){
    $connection = null;
    $db = parse_ini_file("../conf/mysql.ini");

    $host = $db['host'];
    $database = $db['database'];
    $user = $db['user'];
    $password = $db['password'];

    $connection = new mysqli($host, $user, $password);
    // Check connection
    if ($connection->connect_error) {
        return null;
    }
    return $connection;
}

?>



