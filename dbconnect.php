<?php
  $user="zalkadri";
  $hn="earth.cs.utep.edu";
  $un="$user";
  $db="$user";
  $pw="silky";
  //$hn = 'localhost';
  //$db = 'assignment';
  //$un = 'root';
  //$pw = '';
	$connection = new mysqli($hn, $un, $pw, $db);
    if ($connection->connect_error) die($connection->connect_error);
    
?>	