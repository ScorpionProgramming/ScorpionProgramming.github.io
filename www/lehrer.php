<?php
$id = 1;    //lehrer ID
$record = null;
$writeSuccess = false;
require_once("connectDB.php");
$db = connect();//= new mysqli("localhost", "root", "", "planer"); //TODO: Datenbank ändern.
if ($db->connect_errno) {
    printf("Connect failed: %s\n", $db->connect_error);
    exit();
}

// Anfangs alle Fächer aus der DB holen und im array speichern um sie einfacher anzudrucken und später zu prüfen(beim speichern neues Fach hinzufügen).
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
        $writeSuccess = true;
    }
    // Fächer 
    $array_hidden_faecher = array();
    $array_hidden_faecher = explode( ";", $_POST["faecher"] );
    foreach ($array_hidden_faecher as $key => $value) {
        $fach_id =0;
        if (isset($value) && trim($value) !="") {
           if (!in_array($value,$record_alle_faecher)) {    // Fach noch nicht in DB vorhanden
               // Fach hinzufügen
               $fach_id = count($record_alle_faecher) + 1; //TODO: gefällt mir nicht! Nummer nicht einfach hochzählen... ggf. sind welche zwischendruch frei (durch löschen)
               $insert = "INSERT INTO faecher (id,bezeichnung) VALUES (".$fach_id.",'".$value."')";
               if ($result = $db->query($insert)) {
                  $record_alle_faecher[$fach_id]=$value;
                  $insert = "INSERT INTO lehrer_faecher (lehrer,fach) VALUES (".$id.",".$fach_id.")";
                  $db->query($insert);
               }
           }
           else {
               // ID suchen wenn Fach bereits existiert, aber noch nicht dem Lehrer zugeordnet ist
               $fach_id = array_search($value,$record_alle_faecher);
               $insert = "INSERT INTO lehrer_faecher (lehrer,fach) VALUES (".$id.",".$fach_id.")";
               $db->query($insert);
           }
        }
    }
}

// Daten aus Datenbank lehrer
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
         .test{
            margin-bottom: 0px!important;
         }

        .profilbild{
            width: 225px;
            hight: 225x;
        }

        .hakenbild {
            max-width: 35px;
            max-height: 35px;
        }

        input.unstyled, input.unstyled:disabled, input.unstyled:focus {
            border: solid 0px white;
            outline: 0;
            background-color: white;
        }

        .hovermebaby {
            cursor: pointer;
        }
        </style>
        <?php include("includes.html"); ?>
    </head>

    <body>
    <?php include("header.html"); ?>
       <form action="#" method="POST" onsubmit="return validateForm()" enctype="multipart/form-data"> 

          <div class="jumbotron test">
             <h2 class="page-title">Mein Profil</h2>
          </div>
                                   
          <div class="alert alert-success alert-dismissible fade show <?= $writeSuccess ? '' : 'hidden' ?>" role="alert">
            hat geklappt, keule!
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
               <span aria-hidden="true">&times;</span>
            </button>
          </div> 
          <br/><br/>         
          
          <div class="container-fluid">
            <!--TODO: file-dialog und Bild in DB speichern -->
      <!--      <input type="file" placeholder="Bild" name="image" class="form-control" />   https://d30y9cdsu7xlg0.cloudfront.net/png/17241-200.png            -->
             <img src="http://simpleicon.com/wp-content/uploads/add-user.png" class="rounded float-left profilbild" />  
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
                      <div id="passwort-alert" class="alert alert-danger alert-dismissible" role="alert">
                         Die eingegebenen Passwörter stimmen nicht überein.
                         <button type="button" class="close" onclick="return dismissAlert();">
                            <span aria-hidden="true">&times;</span>
                         </button>
                      </div>
                    </div>
                </div>
             </div>
             <br/> <br/> <br/>

             <div class="form-row">
                <div class="form-group col-md-2">
                   <h4>Meine Fächer</h4>
                </div>
             </div>
             <p>
             <div class="form-row">
                <div class="col-md-2">
                   <input id="inputNeuesFach" class="form-control" type="text" placeholder="neues Fach" value=""/>
                </div>
                <button type="button" class="btn btn-dark btn-sm" onclick="neuesFach()"> &#10003 </button>
             </div>
            <!-- <a class="hovermebaby"><img src="../images/button.png" class="hakenbild" onclick="neuesFach()" /></a>-->
             <ul id="fachListe">                           
                <?php foreach ($record_faecher as $key => $value) { ?> 
                   <li><input disabled="disabled" type="text" class="unstyled fach-feld" value="<?= $record_alle_faecher[$value["fach"]] ?>" /></li>                   
                <?php } ?>
             </ul>
             <input id="hiddenFaecher" type="hidden" name="faecher" value="" />

             <div class="form-row">                   
                <div class="col-md-6"></div>
                   <div class="form-group col-md-1">
                      <button type="submit" class="btn btn-dark">Speichern</button>
                   </div>
                </div>
             </div>

          </div> <!--  container ende -->       
        </form>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.0/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
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
                
                if(success){
                    $('#hiddenFaecher').val('');
                    //feacher sammeln
                    var fachstring = '';
                    $('.fach-feld').each(function(i){
                        fachstring += $(this).val() + ';';
                    });
                    $('#hiddenFaecher').val(fachstring);
                }

                return success;
            }

            function dismissAlert() {
                $('#passwort-fehler').addClass('hidden');
            }

            function neuesFach() {
                var val = $('#inputNeuesFach').val();
                if(!val.trim()){
                    alert("das ist nicht ok.");
                    return;
                }

                var li = $('<li>');
                var input = $('<input>');
                input.addClass('unstyled fach-feld');
                input.attr('disabled', 'disabled');
                input.attr('type', 'text');
                input.attr('value', val);
                li.append(input);
                $('#fachListe').append(li);

                $('#inputNeuesFach').val('');
            }
        </script>
    </body>
</html>