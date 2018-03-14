<html>
<head>
    <?php include("includes.html");?>
</head>
<body>
    <?php include("header.html");?>


<!-- Sidebar -->
    <div id="sidebar-wrapper">
        <ul class="sidebar-nav">
            <li class="sidebar-brand">
                <a href="#">
                    Start Bootstrap
                </a>
            </li>
            <li>
                <a href="#">Dashboard</a>
            </li>
            <li>
                <a href="#">Shortcuts</a>
            </li>
            <li>
                <a href="#">Overview</a>
            </li>
            <li>
                <a href="#">Events</a>
            </li>
            <li>
                <a href="#">About</a>
            </li>
            <li>
                <a href="#">Services</a>
            </li>
            <li>
                <a href="#">Contact</a>
            </li>
        </ul>
    </div>
    <!-- /#sidebar-wrapper -->
    
    <a href="#menu-toggle" class="btn btn-secondary" id="menu-toggle">Toggle Menu</a>
    
    <?php
        // Verbindung zur Datenbank herstellen
        require_once "connectDB.php";

        // SQL-Anfrage: Ergebnis ist stets eine Tabelle
        $sql="SELECT * FROM kurs";

        // Anfrage ausführen
        $result=getQueryResult($sql) or exit("Fehler im SQL Kommando: $sql");

        // Tabelle in HTML darstellen
        echo "<table class='table table-bordered'>\n";
        echo "<thead>\n";
        echo "<tr>\n";
        echo "<th scope='col'>ID</th>\n";
        echo "<th scope='col'>Kursname</th>\n";
        echo "<th scope='col'>LehrerID</th>\n";
        echo "<th scope='col'>FachID</th>\n";
        echo "</tr>\n";
        echo "</thead>\n";
        echo "<tbody>\n";
        while ($row=mysqli_fetch_row($result))
        {
            foreach ($row as $item){    // jedes Element $item der Zeile $row durchlaufen
                echo "<td scope='row'>$item</td>";
            }
            echo "</tr>\n";
        }
        echo "</tbody>\n";
        echo "</table>\n";

        function getAllFaecher(){
            $sql = "SELECT * FROM faecher";
            $result = getQueryResult($sql) or exit("Fehler bei SQL Kommando (vermutlich leer): $sql");

            while ($row = mysqli_fetch_row($result))
            {
                // jedes Element $item der Zeile $row durchlaufen
                echo "<option>$row[1]</option>";
            }
        }
    
        function getFach($fach){
            echo $fach;
            $sql = "SELECT ID FROM planer.faecher WHERE bezeichnung = '$fach'";
            $result = getQueryResult($sql) or exit("Fehler bei SQL Kommando: $sql");
            $row = mysqli_fetch_row($result);
            echo $row[0];
            return $row[0];
        }

        function saveKurs(){
            //kopiert aus "schueler.php"
            $connection = connect();
            $id = 9;
            if($connection != null){
                //echo "hidden: ".$_POST['hiddenID'];
                //$id = ($_POST['hiddenID'] < 0) ? getNextID() : $_POST['hiddenID'];
                $id += 1;
                $lehrerID = 1;
                $fachID = getFach($_POST['fach']);
                $kursBez = $_POST['kursBez'];
                $query = "INSERT INTO planer.kurs (id, bezeichnung, lehrerID, fachID) VALUES ('$id', '$kursBez', '$lehrerID', '$fachID');";
                echo $query;
                
                //nochmal schauen was hier gemacht werden muss
                $result = $connection->query($query);

                //kurs_schueler($kurs, $id, $connection);
            }
        }
    ?>
    
    <form action="#" method="POST">
        <div class="form-group">
            <label for="inputAddress">Kurs Bezeichnung</label>
            <input type="text" class="form-control" id="inputKurs" placeholder="Kursname angeben..." name="kursBez">
        </div>
        <div class="form-group col-md-4">
            <label for="inputState">zuständiges Fach:</label>
            <select id="inputState" class="form-control" name=fach>
                <option selected>Fach auswählen...</option>
                <!-- <option>...</option> -->
                <?php
                   getAllFaecher();
                ?>
            </select>
        </div>
        <div class="form-group row">
            <div class="col-sm-10">
                <button type="submit" class="btn btn-primary" name="insert">Hinzufügen</button>
                <button type="button" class="btn btn-danger" name="delete">Löschen</button>
            </div>
        </div>
    </form>
    
    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
    </script>
</body>
</html>

<?php
    if(isset($_POST['insert'])){
        saveKurs();
    }
?>