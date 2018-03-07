
<!DOCTYPE html>
<html>
<head>
    <?php require_once("includes.html");?>
    <?php require_once("connectDB.php");?>
</head>
<body>

<?php
// function fillField($fieldName, $default){
//     return isset($_POST[$fieldName]) ? $_POST[$fieldName] : $default;
// }
if(isset($_GET['id']))
{ 
    
}
$id = intval($_GET['id']);
//$con = connect();
$sql= "SELECT * FROM schueler WHERE id =".$id;
$result = getQueryResult($sql);
if($result == null){
    $row = emptySchueler();
}else{    
    $row = mysqli_fetch_assoc($result);
    $kurseKlassen = getKurse($row['id']);
}

function emptySchueler(){
    $row = array(
        "id" => -1,
        "vorname" => "",
        "nachname"   => "",
        "email"  => "",
        "geburtstag" => "",        
    );
    return $row;
}

//mysqli_close($con);
?>
<form action="#" method="POST" id="schuelerForm">
            <div class="container-fluid">
                <input type="text" name="hiddenID" value="<?php echo $row['id'];?>"/>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="text" value="<?php echo $row['vorname'];?>" placeholder="Vorname" name="vorname" class="form-control" />
                    </div>
                    <div class="form-group col-md-3">
                        <input type="text" value="<?php echo $row['nachname'];?>" placeholder="Nachname" name="nachname" class="form-control" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <input type="email" value="<?php echo $row['email'];;?>" class="form-control" placeholder="E-Mail" name="email" />
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-3">
                        <input type="date" value="<?php echo $row['geburtstag'];;?>" class="form-control" name="geburtstag" />
                    </div>

                    <div class="form-group md-3">
                        <select class="custom-select" id="kursListe" name="kursKlasse">
                            <option value="-1">Keine</option>
                            <?php
                            $con = connect();
                            $queryResult = getQueryResult("SELECT id, bezeichnung FROM planer.kurs;");
                            if($queryResult != null){
                                while($row = mysqli_fetch_assoc($queryResult)){
                                    echo "<option ";
                                    //echo ($row['id'] == $_POST['kursKlasse']) ? "selected" : "";
                                    echo " value='".$row['id']."'>".$row['bezeichnung']."</option>";
                                }
                            }
                            ?>
                        </select>
                        <label class="Kurse"><?php echo $kurseKlassen ?></label>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group col-md-1">
                        <button id="butSub" class="btn btn-dark" name="submit"/>Speichern</button>
                    </div>
                </div>
            </div>
        </form>
</body>
<?php require_once("JSincludes.html");?>
</html>