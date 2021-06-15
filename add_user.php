<?php

require_once 'dbconnect.php';
session_start();

if(isset($_SESSION['username'])){
echo <<< _END1
	<html>
	<head>
		<title> Main Page</title>
	</head>
	<body>
	<h1> Welcome to Register Page </h1>
	<a href="index.php">Main Page</a><br>
	<a href='admin.php'>Admin</a><br>
	<a href="user.php">User</a><br>
	<a href="signout.php">Sign Out</a><br>
	</body>
_END1;
}
else {
	echo <<< _END1
	<html>
	<head>
		<title> Main Page</title>
	</head>
	<body>
		<h1> Welcome to Register Page </h1>
		<a href="index.php">Main Page</a><br>
		<a href='admin.php'>Admin</a><br>
		<a href="user.php">User</a><br>
		<a href="signin.php">Sign In</a><br>
	</body>
_END1;
}
	
  if (isset($_POST['username']) &&
      isset($_POST['password']) &&
	  isset($_POST['firstname']) &&
	  isset($_POST['lastname']) 
	  )
    {
	$fn_temp = mysql_entities_fix_string($connection, $_POST['firstname']);
	$ln_temp = mysql_entities_fix_string($connection, $_POST['lastname']);
	$un_temp = mysql_entities_fix_string($connection, $_POST['username']);
    $pw_temp = mysql_entities_fix_string($connection, $_POST['password']);
	$d=mktime(11, 14, 54, 8, 12, 2014);
	$acc_temp = date("h:i:sa", $d);
	$log_temp = date("h:i:sa", $d);
	$type_temp = $_POST['name'];
		
	$fail ="";	
	$fail  = $fn_temp;
    $fail  = validate_forename($fn_temp);
    $fail .= validate_surname($ln_temp);
    $fail .= validate_username($un_temp);
    $fail .= validate_password($pw_temp);
	
    if ($fail == "")
    {
    echo "Form data successfully validated: ";
	$salt1 = "Salt1&h*";
	$salt2 = $un_temp;
    $token = hash('ripemd128', "$salt1$pw_temp$salt2");
	add_user($connection,  $fn_temp, $ln_temp, $un_temp, $token, $acc_temp, $log_temp, $type_temp);

	 header("Location: add_user.php");
	 exit;
	}
	else 
	  echo $fail;
  }
  

echo <<< _END
<html>
  <head>
    <title> Register Form</title>
<script>
      function validate(form)
      {
	    fail = ""
        fail  = validateFirstname(form.firstname.value)
        fail += validateLastname(form.lastname.value)
        fail += validateUsername(form.username.value)
        fail += validatePassword(form.password.value)
        if (fail == "")     return true
        else { alert(fail); return false }
      }

      function validateFirstname(field)
      {
		return (field == "") ? "No First Name was entered.": ""
      }

      function validateLastname(field)
      {
		return (field == "") ? "No Last Name was entered." : ""
      }

      function validateUsername(field)
      {
        if (field == "") return "No Username was entered.";
        else if (field.length < 5)
          return "Usernames must be at least 5 characters."
        else if (/[^a-zA-Z0-9_-]/.test(field))
          return "Only a-z, A-Z, 0-9, - and _ allowed in Usernames."
        return ""
      }

      function validatePassword(field)
      {
        if (field == "") return "No Password was entered."
        else if (field.length < 6)
          return "Passwords must be at least 6 characters."
        else if (!/[a-z]/.test(field) ||
                 !/[0-9]/.test(field))
          return "Passwords require one each of a-z, A-Z and 0-9."
        return ""
      }
 
 </script> 
 </head>
 <body>
<h2> Please Enter required fields for registration </h2>
<form method="post" action="add_user.php" onSubmit="return validate(this)"><pre>
      Select User type  <select name="name">
		  <option value="administrator">Administrator</option>
		  <option value="regular">Regular</option> </select><br>
      User Name 	<input type="text" name="username" ><br>
      First Name	<input type="text" name="firstname"><br>
      Last Name 	<input type="text" name="lastname" ><br>
      Password  	<input type="text" name="password" ><br>
	  
			<input type="submit" value = "signup">
</pre>
</form>
 </body>
</html>
_END;

   function add_user($connection, $fn, $ln, $un, $pw, $type, $acc, $log )
    {
    $query  = "INSERT INTO userr VALUES('$fn', '$ln', '$un', '$pw', '$type', '$acc', '$log')";
    $result = $connection->query($query);
    if (!$result) die($connection->error);
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
    function fix_string($string)
  {
    if (get_magic_quotes_gpc()) $string = stripslashes($string);
    return htmlentities ($string);
  }
  
  
  function validate_forename($field)
  {
  	return ($field == "") ? "No First name was entered<br>": "";
  }
  
  function validate_surname($field)
  {
  	return($field == "") ? "No Lastname was entered<br>" : "";
  }
  
  function validate_username($field)
  {
    if ($field == "") return "No Username was entered<br>";
    else if (strlen($field) < 5)
      return "Usernames must be at least 5 characters<br>";
    else if (preg_match("/[^a-zA-Z0-9_-]/", $field))
      return "Only letters, numbers, - and _ in usernames<br>";
    return "";		
  }
  
  function validate_password($field)
  {
    if ($field == "") return "No Password was entered<br>";
    else if (strlen($field) < 6)
      return "Passwords must be at least 6 characters<br>";
    //else if (!preg_match("/[0-9]/", $field))
      //return "Passwords require 1 each of a-z, A-Z and 0-9<br>";
    return "";
  }
  
?>