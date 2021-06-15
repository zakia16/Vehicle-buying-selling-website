<?php

require_once 'dbconnect.php';
session_start();
if (!isset($_SESSION['initiated']))
  {
    session_regenerate_id();
    $_SESSION['initiated'] = 1; 
  }
?>
<html lang = "en">
  <head>
    <title>Signin Page
    </title>
    <link href = "css/bootstrap.min.css" rel = "stylesheet">
  </head>
  <body>
	<body>
	<h1> Welcome to the Signup page !</h1>
	<a href="index.php">Main Page</a><br>
	<a href='admin.php'>Admin</a><br>
	<a href="user.php">User</a><br>
	<a href="signin.php">SignIn</a><br>
	<h3>Enter Username and Password for Sign In</h3> 
</body>
    <div class = "container form-signin">
	
  <?php
	$msg = '';
	if (isset($_POST['login']) && !empty($_POST['username']) && !empty($_POST['password'])) {
		$un_temp = mysql_entities_fix_string($connection, $_POST['username']);
		$pw_temp = mysql_entities_fix_string($connection, $_POST['password']);
		$salt1 = "Salt1&h*";
		$salt2 = $un_temp;
		$token = hash('ripemd128', "$salt1$pw_temp$salt2");
		$query = "SELECT * FROM userr WHERE username='$un_temp'";
		$result = $connection->query($query);
		if (!$result) die($connection->error);
		$row = $result->fetch_array(MYSQLI_NUM);
		if ($_POST['username'] == $row[2] && $token == $row[3]) {
			$_SESSION['username'] = $row[2];
			//echo $_SESSION['username'];
			$_SESSION['password'] = $row[3];
			$_SESSION['firstname'] = $row[0];
			$_SESSION['lastname'] = $row[1];
			setcookie('username', $_SESSION['username'], time()+60*60, '/');
			setcookie('password', $_SESSION['password'], time()+60*60, '/');
			setcookie('firstname', $_SESSION['firstname'], time()+60*60, '/');
			setcookie('lastname', $_SESSION['lastname'], time()+60*60, '/');
				
			echo 'You have entered valid user name and password';
			header("Location: index.php");
			exit;
		}
		else {
			$msg = 'Wrong username or password';
		}
	}
	
	function mysql_entities_fix_string($connection, $string)
	{
	return htmlentities(mysql_fix_string($connection, $string));
	}	
	function mysql_fix_string($connection, $string)
	{
	if (get_magic_quotes_gpc()) $string = stripslashes($string);
	return $connection->real_escape_string($string);
	}
?>
    </div> 
    <!-- /container -->
    <div class = "container">
      <form class = "form-signin" role = "form" 
            action = "<?php echo htmlspecialchars($_SERVER['PHP_SELF']); 
                      ?>" method = "post">
        <h4 class = "form-signin-heading">
          <?php echo $msg; ?>
        </h4>
        <input type = "text" class = "form-control" 
               name = "username" placeholder = "Enter your user name" 
               required autofocus>
        </br>
      <input type = "password" class = "form-control"
             name = "password" placeholder = "Enter your password" required>
      </br>
	<br>	
	<button class = "btn btn-lg btn-primary btn-block" type = "submit" 
            name = "login">Login
    </button>
     </form>
    </div>       
  </body>
</html>
