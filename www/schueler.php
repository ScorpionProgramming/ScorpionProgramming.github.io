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
                        <!--   value="<?php// echo $record["vorname"]; ?>" -->
                        <input type="text" placeholder="Vorname" name="vorname" class="form-control" />
                    </div>
                    <div class="form-group col-md-3">
                        <!--  value="<?php //echo $record["name"]; ?>" -->
                        <input type="text" placeholder="Nachname" name="nachname" class="form-control" />
                    </div>
                </div>
                <div class="form-row">                   
                    <div class="form-group col-md-6">
                        <!-- value="<?php //echo $record["email"]; ?>" -->
                        <input type="email"  class="form-control" placeholder="E-Mail" name="email" />
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
            if(isset($_POST['submit']))
            {
                echo "hallo";
            }
        ?>
    </body>
</html>



