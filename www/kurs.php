<html>
<head>
    <?php include("includes.html");?>
</head>
<body>
    <?php include("header.html");?>


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
    ?>

    <form>
        <div class="form-group">
            <label for="inputAddress">Kurs Bezeichnung</label>
            <input type="text" class="form-control" id="inputKurs" placeholder="Kursname angeben...">
        </div>
        <div class="form-group col-md-4">
            <label for="inputState">zuständiges Fach:</label>
            <select id="inputState" class="form-control">
                <option selected>Fach auswählen...</option>
                <!-- <option>...</option> -->
                <?php
                   getAllFaecher();
                ?>
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