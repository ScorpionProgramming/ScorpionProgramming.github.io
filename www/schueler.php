<!doctype html>
<html lang="de">
    <head>
        <?php require_once("includes.html");?>
        <?php require_once("connectDB.php");?>
    </head>
    <body>
        <?php require_once("header.html");?>

        <form action="schueler" method="POST">
            <div class="container-fluid">
                <input type="hidden" name="hiddenID" value="<?php echo fillField("hiddenID", "-1");?>"/>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="text" value="<?php echo fillField("vorname", "");?>" placeholder="Vorname" name="vorname" class="form-control" />
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" value="<?php echo fillField("nachname", "");?>" placeholder="Nachname" name="nachname" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="email" value="<?php echo fillField("email", "");?>" class="form-control" placeholder="E-Mail" name="email" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="date" value="<?php echo fillField("geburtstag", "");?>" class="form-control" name="geburtstag" />
                    </div>
                    <div class="form-group md-3">
                        <select class="custom-select" id="kursListe" name="kursKlasse">
                            <option value="-1">Keine</option>
                            <?php
                            connect();
                            $queryResult = getQueryResult("SELECT id, bezeichnung FROM planer.kurs;");
                            if($queryResult != null){
                                while($row = mysqli_fetch_assoc($queryResult)){
                                    echo "<option ";
                                    if(isset($_POST['kursKlasse'])){
                                        echo ($row['id'] == $_POST['kursKlasse']) ? "selected" : "";
                                    }
                                    echo " value='".$row['id']."'>".$row['bezeichnung']."</option>";
                                }
                            }
                            ?>
                        </select>
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

function fillField($fieldName, $default){
    return isset($_POST[$fieldName]) ? $_POST[$fieldName] : $default;
}

// function getQueryResult($query){
//     $result = null;
//     $connection = connect();
//     if($connection != null){
//         $result = $connection->query($query);
//         if (mysqli_num_rows($result) > 0){
//             return $result;
//         }else{
//             return null;
//         }
//     }
// }

function getNextID(){
    $nextID = -1;
    $queryResult = getQueryResult("Select MAX(id)+1 from planer.schueler");
    if ($queryResult != null){
        $firstrow = mysqli_fetch_row($queryResult);
        if($firstrow[0] == 0){
            $nextID = 1;
        }else{
            $nextID = $firstrow[0];
        }
    }
    return $nextID;
}

function checkIfEmpty($wert){
    return empty($wert) ? "null" : "'$wert'";
}

function schuelerToDatabase(){
    $connection = connect();
    if($connection != null){
        echo "hidden: ".$_POST['hiddenID'];
        $id = ($_POST['hiddenID'] < 0) ? getNextID() : $_POST['hiddenID'];
        $nachname = checkIfEmpty($_POST['nachname']);
        $vorname = checkIfEmpty($_POST['vorname']);
        $email = checkIfEmpty($_POST['email']);
        $geburtstag = checkIfEmpty($_POST['geburtstag']);
        $kurs = checkIfEmpty($_POST['kursKlasse']);
        $query = "INSERT INTO planer.schueler (id, nachname, vorname, email, geburtstag) VALUES ($id, $nachname, $vorname, $email, $geburtstag);";
        $result = $connection->query($query);

        kurs_schueler($kurs, $id, $connection);

    }
}

function kurs_schueler($kursID, $schuelerID, $connection){
    echo intval($kursID);
    if(intval($kursID) > 0){
        $query = "INSERT INTO planer.schueler_klasse (schueler, klasse) VALUES ('".$schuelerID."', $kursID);";
        $connection->query($query);
    }
}


function getAllSchueler(){
    $queryResult = getQueryResult("SELECT * from planer.schueler");
    return $queryResult;
}

function displayQueryResult($result){
    if ($result != null){
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "id: " . $row["id"]. " - Name: " . $row["nachname"]. " " . $row["vorname"]. "<br>";
            }
        } else {
            echo "0 results";
        }
    }
}
?>



