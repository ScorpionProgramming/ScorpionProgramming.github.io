<?php
$id = 1;
$record = null;

$db = new mysqli("localhost", "root", "", "Lehrer");
if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}

$record_alle_faecher = array();
$select = "SELECT * FROM faecher";
if ($result = $db->query($select)) {
    while ($fach = $result->fetch_assoc()) {
        $record_alle_faecher[$fach["id"]] = $fach["bezeichnung"];
    }
    $result->free();
}

// Post -> Daten in die DB Speichern
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST["nachname"];
    $vorname = $_POST["vorname"];
    $email = $_POST["email"];
    $passphrase = "";    
    // Passwort nur speichern/ändern wenn es auch gesetzt ist
    if(isset($_POST["passwort"]) && trim($_POST["passwort"]) !="")
    {
        $passphrase = ", passwort = '".md5($_POST["passwort"])."'";
    }

    $update = "UPDATE lehrer SET name = '".$name."', vorname = '".$vorname."', email = '".$email."'".$passphrase." WHERE id = ".$id.";";
    if($result = $db->query($update)) {
        printf("Hat geklappt, Keule!");  // TODO: hier eine Allertbox.. aber wie?
    } else {
        printf("Fehler.");
    }
    // Fächer 
    $fach = $_POST["fach"];    
    if (isset($fach) && trim($fach) !="") {
        $fach_id =0;
        if (!in_array($fach,$record_alle_faecher)) {    // Fach noch nicht in DB vorhanden
            // Fach hinzufügen
            $fach_id = count($record_alle_faecher) + 1; //TODO: gefällt mir nicht! Nummer nicht einfach hochzählen... ggf. sind welche zwischendruch frei (durch löschen)
            $insert = "INSERT INTO faecher (id,bezeichnung) VALUES (".$fach_id.",'".$fach."')";
            if ($result = $db->query($insert)) {
                $record_alle_faecher[$fach_id]=$fach;
            }
        }
        else {
            // ID suchen wenn Fach bereits existiert, aber noch nicht dem Lehrer zugeordnet ist
            $fach_id = array_search($fach,$record_alle_faecher);
        }
        $insert = "INSERT INTO lehrer_faecher (lehrer,fach) VALUES (".$id.",".$fach_id.")";
        $db->query($insert);

    }
}

// Daten aus Datenbank 
$select = "SELECT * FROM lehrer WHERE id = ".$id;
if ($result = $db->query($select)) {
    if(!($record = $result->fetch_assoc())) {
        printf("Kein Datensatz vorhanden.");
        exit();
    }
    $result->free();
}

$record_faecher = array();
$select = "SELECT * FROM lehrer_faecher WHERE lehrer = ".$id ;
if ($result = $db->query($select)) {
    while ($fach = $result->fetch_assoc()) {        
        array_push($record_faecher, $fach);
    }
    $result->free();
}
$db->close();
?>
<!DOCTYPE html>
<html>
    <head>
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
        <style type="text/css">
        .hidden {
            display: none;
        }
        </style>
        <?php include("includes.html"); ?>
    </head>

    <body>
    <?php include("header.html"); ?>
       <form action="#" method="POST" onsubmit="return validateForm()">                            
          <div class="jumbotron">
             <h2 class="page-title">Mein Profil</h2>
          </div>
          <div class="container-fluid">
            <!--TODO: file-dialog und Bild in DB speichern -->
             <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcSURc4zOGXlV7LWQ9nywhW8TGWDzWQMZ2WDi-0BshcM5KCBeZIGig" class="rounded float-left" />  
             <div class="form-row"> 
                <div class="form-group col-md-3">
                   <input type="text" placeholder="Vorname" name="vorname" class="form-control" value="<?php echo $record["vorname"]; ?>" />
                </div>
                <div class="form-group col-md-3">
                   <input type="text" placeholder="Nachname" name="nachname" class="form-control" value="<?php echo $record["name"]; ?>" />
                </div>
             </div>
             
             <div class="form-row">                   
                <div class="form-group col-md-6">
                   <input type="email"  class="form-control" placeholder="E-Mail" name="email" value="<?php echo $record["email"]; ?>" />
                </div>
             </div>  

             <div class="form-row">                   
                <div class="form-group col-md-3">
                   <input type="password" placeholder="Passwort" class="form-control" name="passwort" id="passwort" value="" />
                </div>
                <div class="form-group col-md-3">
                   <input type="password" placeholder="Passwort bestätigen" class="form-control" id="passwort2" value="" />
                </div>
             </div>              

             <div class="form-row">
                <div class="form-group col-md-6">
                   <div id="passwort-fehler" class="hidden">
                      <div class="alert alert-danger alert-dismissible fade show" role="alert">
                         Die eingegebenen Passwörter stimmen nicht überein.
                         <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                         </button>
                      </div>
                   </div>
                </div>
             </div>
             <br/> <br/>

             <div class="form-row">
                <div class="form-group col-md-2">
                   <h4>Meine Fächer</h4>
                </div>
             </div>
             <p>
             <input type="text" placeholder="neues Fach" name="fach" value=""/>
             <ul>                           
                <?php foreach ($record_faecher as $key => $value) { ?> 
                   <li> <?= $record_alle_faecher[$value["fach"]] ?></li>                   
                <?php } ?>
             </ul>

             <div class="form-row">                   
                <div class="col-md-6"></div>
                   <div class="form-group col-md-1">
                      <button type="submit" class="btn btn-dark">Speichern</button>
                   </div>
                </div>
             </div>

          </div> <!--  container ende -->       
        </form>


        <script type="text/javascript">
            function validateForm(){
                var success = true;

                var password = document.getElementById("passwort").value;
                if(password != "") {
                    if(password != document.getElementById("passwort2").value) {
                        success = false;
                        document.getElementById("passwort-fehler").className = "";
                    }
                }
                return success;
            }
        </script>
    </body>
</html>