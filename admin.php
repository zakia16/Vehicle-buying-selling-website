<?php

require_once 'dbconnect.php';

session_start();

if(isset($_SESSION['username'])){
	 $a = $_SESSION['username'];
	 $query = "SELECT * FROM userr WHERE username='$a'";
	 $result = $connection->query($query);
	 if (!$result) die($connection->error);
	 $row = $result->fetch_array(MYSQLI_NUM);
	 
	 if($row[6] != 'administrator')
	 {
		echo "<h1> You need to be logged in as an administrator to access this page </h1>";
		exit;
	 }
	 $un = $_SESSION['username'];
	 $fn = $_SESSION['firstname'];
	 $ln = $_SESSION['lastname'];
	echo "<h1> Hi $un, welcome to your page</h1>";  
	  
echo <<< _END1

	<html>
	<head>
		<title> Main Page</title>
	</head>
	<body>
		<a href="index.php">Main Page</a><br>
		<a href='admin.php'>Admin</a><br>
		<a href='user.php'>Users</a><br>
		<a href='add_user.php'>Add New User</a><br>
		<a href="Signout.php">Sign Out</a><br>	
	</body>
_END1;
}

else {	
echo <<< _END2

<html>
<head>
	<title> Main Page</title>
</head>
<body>
<h1> Logged in as an admin to access this page!</h1>
	<a href="index.php">Main Page</a><br>
	<a href='admin.php'>Admin</a><br>
	<a href="user.php">User</a><br>
	<a href="signin.php">SignIn</a><br>
	<a href="add_user.php">Add New User</a><br>
</body>
_END2;
}
?>