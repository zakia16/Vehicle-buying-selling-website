<?php

session_start();

if(isset($_COOKIE['username'])){
	if(!isset($_SESSION['username'])){
		$_SESSION['username'] = $_COOKIE['username'];
		$_SESSION['password'] = $_COOKIE['password'];
		$_SESSION['firstname'] = $_COOKIE['firstname'];
		$_SESSION['lastname'] = $_COOKIE['lastname'];
	}
}

if(isset($_SESSION['username'])){
	//echo $_SESSION['username'];
echo <<< _END1
<html>
<head>
	<title> Main Page</title>
</head>
<body>
	<h1> Hi 
_END1;
echo $_SESSION['username']; 
echo <<< _END1
, Welcome to the Home page !</h1>
	<a href="index.php">Main Page</a><br>
	<a href='admin.php'>Admin</a><br>
	<a href="user.php">User</a><br>
	<a href='add_user.php'>Add New User</a><br>
	<a href="signout.php">Sign Out</a><br>
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
<h1> Welcome to the Home page !</h1>
	<a href="index.php">Main Page</a><br>
	<a href='admin.php'>Admin</a><br>
	<a href="user.php">User</a><br>
	<a href="signin.php">SignIn</a><br>
</body>
_END2;
}

?>