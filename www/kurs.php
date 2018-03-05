<?php
    $id = 1;
    $record = null;

    // Beispiel: 
    // https://www.php-kurs.com/mysql-datenbank-auslesen.htm
    // http://www.iti.fh-flensburg.de/lang/php/tabelle-darstellen.htm
    // ^^^^^ alles was ich brauche


    $db = new mysqli("localhost", "root", "", "kurs");
    if($db->connect_errno){
        printf("Connection failed: %s\n", $db->connect_error);
        exit;
    }

    require_once ('konfiguration.php');
    $db_link = mysqli_connect (
                        MYSQL_HOST, 
                        MYSQL_BENUTZER, 
                        MYSQL_KENNWORT, 
                        MYSQL_DATENBANK
                        );
    
    $sql = "SELECT * FROM adressen";
    
    $db_erg = mysqli_query( $db_link, $sql );
    if ( ! $db_erg )
    {
    die('Ungültige Abfrage: ' . mysqli_error());
    }
    
    echo '<table border="1">';
    while ($zeile = mysqli_fetch_array( $db_erg, MYSQL_ASSOC))
    {
    echo "<tr>";
    echo "<td>". $zeile['id'] . "</td>";
    echo "<td>". $zeile['nachname'] . "</td>";
    echo "<td>". $zeile['vorname'] . "</td>";
    echo "<td>". $zeile['akuerzel'] . "</td>";
    echo "<td>". $zeile['strasse'] . "</td>";
    echo "<td>". $zeile['plz'] . "</td>";
    echo "<td>". $zeile['telefon'] . "</td>";
    echo "</tr>";
    }
    echo "</table>";
    
    mysqli_free_result( $db_erg );

    $record_alle_kurse = array();
    $select = "SELECT * FROM kurse";
    if($result = $db->query($select)){
        while($kurs = $result->fetch_assoc()){
            $record_alle_kurse[$kurs["id"]] == 
        }
        $result->free();
    }
?>

<html>
<head>
    <?php include("includes.html");?>
</head>
<body>
    <?php include("header.html");?>
    <form>
        <div class="form-group">
            <label for="inputAddress">Kurs Bezeichnung</label>
            <input type="text" class="form-control" id="inputKurs" placeholder="Kursname angeben...">
        </div>
        <div class="form-group col-md-4">
            <label for="inputState">Zuständiger Lehrer</label>
            <select id="inputState" class="form-control">
                <option selected>Lehrer auswählen</option>
                <option>...</option>
            </select>
        </div>
        <div class="form-group col-md-4">
            <label for="inputState">zuständiges Fach:</label>
            <select id="inputState" class="form-control">
                <option selected>Fach auswählen...</option>
                <option>...</option>
            </select>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary">Hinzufügen</button>
            </div>
        </div>
    </form>

</body>
</html>