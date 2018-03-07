<!DOCTYPE html>
<html>
<head>
    <?php require_once("includes.html");?>
    <?php require_once("connectDB.php");?>
</head>
<body>

<?php require_once("header.html");

function getAllSchueler(){
    $queryResult = getQueryResult("SELECT * from schueler");
    return $queryResult;
}

$con = connect();
$sql= "SELECT * FROM schueler";
$result = mysqli_query($con,$sql);

echo "<table class='table table-sm table-hover'  id='schuelerTable'>
<thead>
<tr>
<th>ID</th>
<th>Vorname</th>
<th>Nachname</th>
<th>E-Mail</th>
<th>Geburtstag</th>
<th>Klasse/Kurs</th>
</tr></thead><tbody id='schuelerTableBody'>";
while($row = mysqli_fetch_array($result)) {
    echo "<tr>";
    echo "<td>" . $row['id'] . "</td>";
    echo "<td>" . $row['vorname'] . "</td>";
    echo "<td>" . $row['nachname'] . "</td>";
    echo "<td>" . $row['email'] . "</td>";
    echo "<td>" . $row['geburtstag'] . "</td>";
    echo "<td>" . getKurse($row['id']) . "</td>";
    echo "</tr>";
}
echo "</tbody></table>";


mysqli_close($con);
?>
<br>
<button type="button" id="neuerSchueler">Neuer Schueler</button>
<div id="schuelerEdit"><b>Schueler hier</b></div>

</body>
    <?php require_once("JSincludes.html");?>
    <script src="..\script\schueler.js"></script>
       
</html>