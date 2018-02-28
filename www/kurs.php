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