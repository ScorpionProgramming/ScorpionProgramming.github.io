<!doctype html>
<html lang="de">
    <head>
        <?php require_once("includes.html");?>
        <?php require_once("connectDB.php");?>
		<link rel="stylesheet" type="text/css" href="../style/login.css">
    </head>
  <body class="text-center">
    <form action="?login=1" method="post" class="form-signin">
      Planner<img class="mb-4" src="../images/logo.png" alt="logo">rama
      <h1 class="h3 mb-3 font-weight-normal">Please sign in</h1>
      <label for="inputEmail" class="sr-only">Email address</label>
      <input type="email" id="inputEmail" class="form-control" placeholder="Email address" required autofocus>
      <label for="inputPassword" class="sr-only">Password</label>
      <input type="password" id="inputPassword" class="form-control" placeholder="Password" required>
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
	echo "dsfvdfbgrf";
    $email = $_POST['email'];
    $passwort = $_POST['passwort'];
    
    $statement = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $result = $statement->execute(array('email' => $email));
    $user = $statement->fetch();
        
    //Überprüfung des Passworts
    if ($user !== false && password_verify($passwort, $user['passwort'])) {
        $_SESSION['userid'] = $user['id'];
        die('Login erfolgreich. Weiter zu <a href="geheim.php">internen Bereich</a>');
    } else {
        $errorMessage = "E-Mail oder Passwort war ungültig<br>";
    }
    
}
?>