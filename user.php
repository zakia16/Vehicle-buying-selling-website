<?php

 session_start();
 require_once 'dbconnect.php';
 
 if(isset($_SESSION['username'])){
	$un = $_SESSION['username'];
	$fn = $_SESSION['firstname'];
	$ln = $_SESSION['lastname'];
	echo "<h1> Hi $un, this page contain the Registered User list</h1>"; 
	  
	echo <<< _END1
	<html>
	<head>
		<title> Main Page</title>
	</head>
		<style>
	table {
		font-family: arial, sans-serif;
		border-collapse: collapse;
		width: 20%;
	}

	td, th {
		border: 1px solid #dddddd;
		text-align: left;
		padding: 8px;
	}

	tr:nth-child(odd) {
		background-color: #dddddd;
	}
	</style>
	<body>
	<a href="index.php">Main Page</a><br>
	<a href='admin.php'>Admin</a><br>	
	<a href="user.php">User</a><br>
	<a href="signout.php">Sign Out</a><br>
	</body>
_END1;

$query = "SELECT * FROM userr where user_type='regular'";
$result = $connection->query($query);
if (!$result) die($connection->error);
$row = $result->fetch_array(MYSQLI_NUM);
//echo $_SESSION['username'];
$rows = $result->num_rows;
 
echo <<<_END
  <br>
  <table border="1">
  <tr>
    <th>Username</th>
    <th>Firstname</th>
    <th>Lastname</th>
  </tr>     
	<br>
_END;
 
  for ($j = 0 ; $j < $rows ; ++$j)
  {
    $result->data_seek($j);
    $row = $result->fetch_array(MYSQLI_NUM);
  
    echo <<<_END
	<tr>
		<th>$row[2]</th>
		<th>$row[0]</th>
		<th>$row[1]</th>
    </tr>
_END;
}
    echo <<<_END
	</table>
_END;

$result->close();
}
else {	
echo <<< _END2
	<html>
	<head>
		<title> Main Page</title>
	</head>
	<body>
	<h1> Logged in as an user to access this page!</h1>
	<a href="index.php">Main Page</a><br>
	<a href='admin.php'>Admin</a><br>
	<a href="user.php">User</a><br>
	<a href="signin.php">SignIn</a><br>
	</body>
_END2;
}
?>