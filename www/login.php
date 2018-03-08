<!doctype html>
<html lang="de">
    <head>
        <?php require_once("includes.html");?>
        <?php require_once("connectDB.php");?>
		<link rel="stylesheet" type="text/css" href="../style/login.css">
    </head>
  <body class="text-center">
	<?php 
		if(isset($errorMessage)) {
			echo $errorMessage;
		}
	?>
  
    <form action="?login=1" method="post" class="form-signin">
      Planner<img class="mb-4" src="../images/logo.png" alt="logo">rama
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" name="email" id="inputEmail" class="form-control" maxlength="250" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" name="password" id="inputPassword" class="form-control" maxlength="250" placeholder="Password" required>
      <!--<div class="checkbox mb-3">
        <label>
          <input type="checkbox" value="remember-me"> Remember me
        </label>
      </div>-->
      <button class="btn btn-lg btn-dark btn-block" type="submit">Sign in</button>
      <p class="mt-5 mb-3 text-muted">&copy; 2017-2018</p>
    </form>
  </body>
</html>
<?php require_once("JSIncludes.html");?>

<?php 
session_start();
 $pdo = connect();
if(isset($_GET['login'])) {
    $email = $_POST['email'];
    $passwort = $_POST['password'];
    
    $statement = "SELECT * FROM lehrer WHERE email = '".$email."';";
    $result = getQueryResult($statement);
    $row = mySQLi_fetch_assoc($result);  
	  
    //Überprüfung des Passworts
    if ($row !== false && password_verify($passwort, $row['passwort'])) {
        $_SESSION['email'] = $row['email'];
        //@todo weiterleiten
		redirect('home.php');
    } else {
        $errorMessage = "<br>E-Mail oder Passwort war ungültig<br>";
    }
}

function redirect($url, $statusCode = 303)
{
   header('Location: ' . $url, true, $statusCode);
   die();
}
?>


